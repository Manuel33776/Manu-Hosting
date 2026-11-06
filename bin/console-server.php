#!/usr/bin/env php
<?php

/**
 * Manu Hosting WebSocket Console Server
 * 
 * This server handles real-time console connections for Minecraft servers.
 * It runs as a standalone PHP process on the Debian control plane.
 * 
 * Usage: php bin/console-server.php
 * 
 * Runs as a systemd service on Debian 13.
 */

require_once __DIR__ . "/../vendor/autoload.php";

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use React\Socket\SocketServer;
use React\EventLoop\Factory;

class ConsoleServer implements MessageComponentInterface {
    
    protected $clients = [];
    protected $serverSubscriptions = [];
    protected $loop;
    protected $httpClient;
    
    public function __construct() {
        $this->loop = Factory::create();
        $this->httpClient = new \React\HttpClient\Client($this->loop);
    }
    
    public function onOpen(ConnectionInterface $conn) {
        $query = $conn->httpRequest->getUri()->getQuery();
        parse_str($query, $params);
        
        $token = $params["token"] ?? "";
        $serverUuid = $params["server"] ?? "";
        
        if (!$token || !$serverUuid) {
            $conn->close();
            return;
        }
        
        $this->validateToken($conn, $token, $serverUuid);
    }
    
    public function onMessage(ConnectionInterface $from, $msg) {
        $clientId = $from->resourceId;
        
        if (!isset($this->clients[$clientId])) {
            return;
        }
        
        $data = json_decode($msg, true);
        if (!$data) return;
        
        $action = $data["action"] ?? "";
        $serverUuid = $this->clients[$clientId]["server_uuid"];
        
        switch ($action) {
            case "command":
                $command = $data["command"] ?? "";
                if ($command) {
                    $this->sendCommandToNode($clientId, $command);
                }
                break;
                
            case "ping":
                $from->send(json_encode(["type" => "pong", "timestamp" => time()]));
                $this->clients[$clientId]["last_ping"] = time();
                break;
                
            case "resize":
                break;
        }
    }
    
    public function onClose(ConnectionInterface $conn) {
        $clientId = $conn->resourceId;
        
        if (isset($this->clients[$clientId])) {
            $serverUuid = $this->clients[$clientId]["server_uuid"];
            
            if (isset($this->serverSubscriptions[$serverUuid])) {
                $key = array_search($conn, $this->serverSubscriptions[$serverUuid], true);
                if ($key !== false) {
                    unset($this->serverSubscriptions[$serverUuid][$key]);
                    $this->serverSubscriptions[$serverUuid] = array_values($this->serverSubscriptions[$serverUuid]);
                }
            }
            
            unset($this->clients[$clientId]);
        }
        
        echo "Client disconnected: {$clientId}\n";
    }
    
    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }
    
    protected function validateToken(ConnectionInterface $conn, string $token, string $serverUuid) {
        $apiUrl = getenv("MANU_API_URL") ?: "http://localhost/api/v1";
        
        $request = $this->httpClient->request("GET", "{$apiUrl}/servers/{$serverUuid}/console/validate", [
            "Authorization" => "Bearer {$token}",
            "Accept" => "application/json"
        ]);
        
        $request->then(
            function (\Psr\Http\Message\ResponseInterface $response) use ($conn, $serverUuid, $token) {
                $body = (string)$response->getBody();
                $data = json_decode($body, true);
                
                if ($response->getStatusCode() === 200 && isset($data["success"]) && $data["success"]) {
                    $clientId = $conn->resourceId;
                    $this->clients[$clientId] = [
                        "server_uuid" => $serverUuid,
                        "user_id" => $data["user_id"] ?? 0,
                        "role" => $data["role"] ?? "",
                        "node_id" => $data["node_id"] ?? 0,
                        "api_url" => $data["node_api_url"] ?? "",
                        "api_token" => $data["node_api_token"] ?? "",
                        "last_ping" => time()
                    ];
                    
                    if (!isset($this->serverSubscriptions[$serverUuid])) {
                        $this->serverSubscriptions[$serverUuid] = [];
                    }
                    $this->serverSubscriptions[$serverUuid][] = $conn;
                    
                    $conn->send(json_encode([
                        "type" => "connected",
                        "server_uuid" => $serverUuid,
                        "message" => "Connected to server console. Type commands to send to server."
                    ]));
                    
                    $this->startConsolePolling($clientId);
                    
                    echo "Client {$clientId} connected to server {$serverUuid}\n";
                } else {
                    $conn->send(json_encode([
                        "type" => "error",
                        "message" => $data["error"] ?? "Authentication failed"
                    ]));
                    $conn->close();
                }
            },
            function (\Exception $e) use ($conn) {
                $conn->send(json_encode([
                    "type" => "error",
                    "message" => "Failed to validate token: " . $e->getMessage()
                ]));
                $conn->close();
            }
        );
    }
    
    protected function sendCommandToNode(int $clientId, string $command) {
        if (!isset($this->clients[$clientId])) return;
        
        $client = $this->clients[$clientId];
        $serverUuid = $client["server_uuid"];
        $apiUrl = $client["api_url"];
        $apiToken = $client["api_token"];
        
        if (!$apiUrl || !$apiToken) {
            $this->sendToClient($clientId, [
                "type" => "error",
                "message" => "Node API not configured"
            ]);
            return;
        }
        
        $request = $this->httpClient->request("POST", "{$apiUrl}/agent/servers/{$serverUuid}/console", [
            "Authorization" => "Bearer {$apiToken}",
            "Content-Type" => "application/json",
            "Accept" => "application/json"
        ], json_encode(["command" => $command]));
        
        $request->then(
            function (\Psr\Http\Message\ResponseInterface $response) use ($clientId, $command) {
                $body = (string)$response->getBody();
                $data = json_decode($body, true);
                
                if ($response->getStatusCode() !== 200) {
                    $this->sendToClient($clientId, [
                        "type" => "error",
                        "message" => $data["error"] ?? "Failed to send command"
                    ]);
                }
            },
            function (\Exception $e) use ($clientId) {
                $this->sendToClient($clientId, [
                    "type" => "error",
                    "message" => "Connection error: " . $e->getMessage()
                ]);
            }
        );
    }
    
    protected function startConsolePolling(int $clientId) {
        if (!isset($this->clients[$clientId])) return;
        
        $client = $this->clients[$clientId];
        $serverUuid = $client["server_uuid"];
        $apiUrl = $client["api_url"];
        $apiToken = $client["api_token"];
        
        if (!$apiUrl || !$apiToken) return;
        
        $this->loop->addPeriodicTimer(0.5, function () use ($clientId, $serverUuid, $apiUrl, $apiToken) {
            if (!isset($this->clients[$clientId])) {
                return;
            }
            
            $request = $this->httpClient->request("GET", "{$apiUrl}/agent/servers/{$serverUuid}/console/output", [
                "Authorization" => "Bearer {$apiToken}",
                "Accept" => "application/json"
            ]);
            
            $request->then(
                function (\Psr\Http\Message\ResponseInterface $response) use ($clientId) {
                    if (!isset($this->clients[$clientId])) return;
                    
                    $body = (string)$response->getBody();
                    $data = json_decode($body, true);
                    
                    if ($response->getStatusCode() === 200 && isset($data["output"])) {
                        $this->sendToClient($clientId, [
                            "type" => "output",
                            "data" => $data["output"]
                        ]);
                    }
                },
                function (\Exception $e) use ($clientId) {
                }
            );
        });
    }
    
    protected function sendToClient(int $clientId, array $message) {
        if (isset($this->clients[$clientId])) {
            foreach ($this->serverSubscriptions[$this->clients[$clientId]["server_uuid"]] ?? [] as $conn) {
                if ($conn->resourceId === $clientId) {
                    $conn->send(json_encode($message));
                    break;
                }
            }
        }
    }
    
    public function run(int $port = 8080) {
        $socket = new SocketServer("0.0.0.0:{$port}", $this->loop);
        $server = new IoServer(
            new HttpServer(
                new WsServer($this)
            ),
            $socket,
            $this->loop
        );
        
        echo "WebSocket Console Server started on port {$port}\n";
        $this->loop->run();
    }
}

if (file_exists(__DIR__ . "/../.env")) {
    $lines = file(__DIR__ . "/../.env", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), "#")) continue;
        if (strpos($line, "=") !== false) {
            [$key, $value] = explode("=", $line, 2);
            putenv(trim($key) . "=" . trim($value));
        }
    }
}

$port = (int)(getenv("CONSOLE_WS_PORT") ?: 8080);

$server = new ConsoleServer();
$server->run($port);