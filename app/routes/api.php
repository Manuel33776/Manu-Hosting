<?php

use App\Core\Application;
use App\Models\Server;
use App\Models\Node;
use App\Models\Backup;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Package;
use App\Models\PlatformStatus;
use App\Validation\Validator;

$app = Application::getInstance();
$router = $app->router();

$container = $app->container();

// API v1 routes
$router->group("/api/v1", function ($router) use ($app, $container) {
    // Public API endpoints (no auth)
    $router->get("/status", function () use ($container) {
        $platformStatus = $container->make(\App\Models\PlatformStatus::class);
        $status = $platformStatus->getOverallStatus();
        $wipStatus = $platformStatus->getWipStatus();
        $serversOfflineStatus = $platformStatus->getServersOfflineStatus();
        
        $response = array_merge($status, [
            "wip" => $wipStatus["enabled"],
            "wip_message" => $wipStatus["message"],
            "servers_offline" => $serversOfflineStatus["enabled"],
            "servers_offline_message" => $serversOfflineStatus["message"],
        ]);
        
        header("Content-Type: application/json");
        echo json_encode($response);
    });

    $router->get("/packages", function () use ($container) {
        $packages = $container->make(\App\Models\Package::class)->getAll();
        header("Content-Type: application/json");
        echo json_encode($packages);
    });

    // Node Agent API endpoints (authenticated via node token)
    $router->group("/nodes", function ($router) use ($app, $container) {
        // Node registration/heartbeat
        $router->post("/{id}/heartbeat", function ($params) use ($app, $container) {
            $nodeModel = $container->make(\App\Models\Node::class);
            $node = $nodeModel->findById($params["id"]);
            
            if (!$node || !$app->validateNodeToken($node)) {
                http_response_code(401);
                echo json_encode(["error" => "Unauthorized"]);
                exit;
            }
            
            $input = $app->router()->getRouteParams();
            $nodeModel->updateHeartbeat($params["id"], [
                "cpu_usage" => $input["cpu_usage"] ?? 0,
                "ram_used" => $input["ram_used"] ?? 0,
                "disk_used" => $input["disk_used"] ?? 0,
                "network_rx" => $input["network_rx"] ?? 0,
                "network_tx" => $input["network_tx"] ?? 0,
                "servers_online" => $input["servers_online"] ?? 0,
                "servers_total" => $input["servers_total"] ?? 0,
            ]);
            
            // Return pending commands
            $commands = $app->db()->query(
                "SELECT * FROM server_commands WHERE server_uuid IN (SELECT uuid FROM servers WHERE node_id = ?) AND status = \"pending\"",
                [$params["id"]]
            );
            
            header("Content-Type: application/json");
            echo json_encode(["commands" => $commands]);
        });

        // Server status update from node
        $router->post("/{id}/servers/{uuid}/status", function ($params) use ($app, $container) {
            $nodeModel = $container->make(\App\Models\Node::class);
            $node = $nodeModel->findById($params["id"]);
            
            if (!$node || !$app->validateNodeToken($node)) {
                http_response_code(401);
                echo json_encode(["error" => "Unauthorized"]);
                exit;
            }
            
            $input = $app->router()->getRouteParams();
            $serverModel = $container->make(\App\Models\Server::class);
            $serverModel->updateByUuid($params["uuid"], [
                "status" => $input["status"] ?? "unknown",
                "players_online" => $input["players_online"] ?? 0,
                "players_max" => $input["players_max"] ?? 0,
                "cpu_usage" => $input["cpu_usage"] ?? 0,
                "ram_usage" => $input["ram_usage"] ?? 0,
                "last_seen" => date("Y-m-d H:i:s"),
            ]);
            
            // Record resource usage
            if (isset($input["cpu_usage"], $input["ram_usage"])) {
                $serverModel->recordResourceUsage($params["uuid"], [
                    "cpu_usage" => $input["cpu_usage"],
                    "ram_usage" => $input["ram_usage"],
                    "disk_usage" => $input["disk_usage"] ?? 0,
                ]);
            }
            
            echo json_encode(["success" => true]);
        });

        // Command polling
        $router->get("/{id}/commands", function ($params) use ($app, $container) {
            $nodeModel = $container->make(\App\Models\Node::class);
            $node = $nodeModel->findById($params["id"]);
            
            if (!$node || !$app->validateNodeToken($node)) {
                http_response_code(401);
                echo json_encode(["error" => "Unauthorized"]);
                exit;
            }
            
            $commands = $app->db()->query(
                "SELECT * FROM server_commands WHERE server_uuid IN (SELECT uuid FROM servers WHERE node_id = ?) AND status = \"pending\" ORDER BY created_at ASC LIMIT 10",
                [$params["id"]]
            );
            
            header("Content-Type: application/json");
            echo json_encode(["commands" => $commands]);
        });

        // Command result
        $router->post("/{id}/commands/{cmdId}/result", function ($params) use ($app) {
            $nodeModel = $container->make(\App\Models\Node::class);
            $node = $nodeModel->findById($params["id"]);
            
            if (!$node || !$app->validateNodeToken($node)) {
                http_response_code(401);
                echo json_encode(["error" => "Unauthorized"]);
                exit;
            }
            
            $input = $app->router()->getRouteParams();
            $app->db()->execute(
                "UPDATE server_commands SET status = ?, result = ?, completed_at = NOW() WHERE id = ?",
                [$input["status"] ?? "completed", $input["result"] ?? "", $params["cmdId"]]
            );
            
            echo json_encode(["success" => true]);
        });
    });

    // Bridge API endpoints (authenticated via bridge secret)
    $router->group("/bridge", function ($router) use ($app, $container) {
        $router->post("/player/join", function () use ($app, $container) {
            if (!$app->validateBridgeSecret()) {
                http_response_code(401);
                exit;
            }
            
            $input = $app->router()->getRouteParams();
            $serverModel = $container->make(\App\Models\Server::class);
            
            // Update player count
            $serverModel->updateByUuid($input["server_uuid"], [
                "players_online" => $input["players_online"] ?? 0,
            ]);
            
            // Cancel idle shutdown if active
            // TODO: Notify node agent to cancel idle shutdown timer
            
            echo json_encode(["success" => true]);
        });

        $router->post("/player/quit", function () use ($app, $container) {
            if (!$app->validateBridgeSecret()) {
                http_response_code(401);
                exit;
            }
            
            $input = $app->router()->getRouteParams();
            $serverModel = $container->make(\App\Models\Server::class);
            
            $serverModel->updateByUuid($input["server_uuid"], [
                "players_online" => $input["players_online"] ?? 0,
            ]);
            
            // Start idle shutdown timer if no players
            if (($input["players_online"] ?? 0) === 0) {
                // TODO: Notify node agent to start idle shutdown timer
            }
            
            echo json_encode(["success" => true]);
        });

        $router->post("/inventory/update", function () use ($app) {
            if (!$app->validateBridgeSecret()) {
                http_response_code(401);
                exit;
            }
            
            $input = $app->router()->getRouteParams();
            
            // Store inventory data
            $app->db()->execute(
                "INSERT INTO player_inventory (server_uuid, player_uuid, player_name, inventory_data, enderchest_data, updated_at)
                 VALUES (?, ?, ?, ?, ?, NOW())
                 ON DUPLICATE KEY UPDATE inventory_data = VALUES(inventory_data), enderchest_data = VALUES(enderchest_data), updated_at = NOW()",
                [$input["server_uuid"], $input["player_uuid"], $input["player_name"], json_encode($input["inventory"]), json_encode($input["enderchest"] ?? [])]
            );
            
            echo json_encode(["success" => true]);
        });

        $router->post("/anticheat/alert", function () use ($app) {
            if (!$app->validateBridgeSecret()) {
                http_response_code(401);
                exit;
            }
            
            $input = $app->router()->getRouteParams();
            
            $app->db()->insert("anticheat_alerts", [
                "server_uuid" => $input["server_uuid"],
                "player_uuid" => $input["player_uuid"],
                "player_name" => $input["player_name"],
                "rule" => $input["rule"],
                "severity" => $input["severity"],
                "details" => json_encode($input["details"] ?? []),
                "evidence" => json_encode($input["evidence"] ?? []),
                "created_at" => date("Y-m-d H:i:s"),
            ]);
            
            echo json_encode(["success" => true]);
        });
    });

    // Console API endpoints
    $router->get("/servers/{id}/console/validate", function ($params) use ($app, $container) {
        $serverModel = $container->make(\App\Models\Server::class);
        $server = $serverModel->findById($params["id"]);
        
        if (!$server) {
            http_response_code(404);
            echo json_encode(["error" => "Server not found"]);
            exit;
        }
        
        // Check access
        $userId = $app->session()->get("user_id");
        $role = $app->session()->get("role");
        
        if ($role !== "owner" && $role !== "admin" && $server["user_id"] != $userId) {
            http_response_code(403);
            echo json_encode(["error" => "Forbidden"]);
            exit;
        }
        
        // Get node info
        $nodeModel = $container->make(\App\Models\Node::class);
        $node = $nodeModel->findById($server["node_id"]);
        
        if (!$node) {
            http_response_code(404);
            echo json_encode(["error" => "Node not found"]);
            exit;
        }
        
        // Return node API info for WebSocket server
        header("Content-Type: application/json");
        echo json_encode([
            "success" => true,
            "user_id" => $userId,
            "role" => $role,
            "node_id" => $node["id"],
            "node_api_url" => $node["api_url"] ?? "",
            "node_api_token" => $node["api_token"] ?? "",
        ]);
    });

    $router->get("/servers/{id}/console/token", function ($params) use ($app, $container) {
        // Generate a temporary token for WebSocket connection
        $serverModel = $container->make(\App\Models\Server::class);
        $server = $serverModel->findById($params["id"]);
        
        if (!$server) {
            http_response_code(404);
            echo json_encode(["error" => "Server not found"]);
            exit;
        }
        
        $userId = $app->session()->get("user_id");
        $role = $app->session()->get("role");
        
        if ($role !== "owner" && $role !== "admin" && $server["user_id"] != $userId) {
            http_response_code(403);
            echo json_encode(["error" => "Forbidden"]);
            exit;
        }
        
        // Generate a short-lived token (5 minutes)
        $token = bin2hex(random_bytes(32));
        $expires = time() + 300;
        
        $app->db()->execute(
            "INSERT INTO console_tokens (token, server_uuid, user_id, expires_at, created_at) VALUES (?, ?, ?, FROM_UNIXTIME(?), NOW())",
            [$token, $server["uuid"], $userId, $expires]
        );
        
        header("Content-Type: application/json");
        echo json_encode([
            "success" => true,
            "token" => $token,
            "expires_at" => $expires,
            "server_uuid" => $server["uuid"]
        ]);
    });

    // Authenticated API endpoints (require user session)
    $router->group("", function ($router) use ($app, $container) {
        // Apply auth middleware
        $router->middleware(function ($request, $next) use ($app) {
            if (!$app->session()->has("user_id")) {
                http_response_code(401);
                echo json_encode(["error" => "Unauthorized"]);
                exit;
            }
            return $next($request);
        });

        // User info
        $router->get("/user", function () use ($app) {
            $userModel = $container->make(\App\Models\User::class);
            $user = $userModel->findById($app->session()->get("user_id"));
            unset($user["password"]);
            header("Content-Type: application/json");
            echo json_encode($user);
        });

        // Server API
        $router->get("/servers", function () use ($app, $container) {
            $serverModel = $container->make(\App\Models\Server::class);
            $userId = $app->session()->get("user_id");
            $role = $app->session()->get("role");
            
            $filters = [];
            if ($role !== "owner" && $role !== "admin") {
                $filters["user_id"] = $userId;
            }
            
            $result = $serverModel->getAll($filters);
            header("Content-Type: application/json");
            echo json_encode($result);
        });

        $router->get("/servers/{id}", function ($params) use ($app, $container) {
            $serverModel = $container->make(\App\Models\Server::class);
            $server = $serverModel->findById($params["id"]);
            
            if (!$server) {
                http_response_code(404);
                echo json_encode(["error" => "Not found"]);
                exit;
            }
            
            // Check access
            $userId = $app->session()->get("user_id");
            $role = $app->session()->get("role");
            if ($role !== "owner" && $role !== "admin" && $server["user_id"] != $userId) {
                http_response_code(403);
                echo json_encode(["error" => "Forbidden"]);
                exit;
            }
            
            header("Content-Type: application/json");
            echo json_encode($server);
        });

        $router->post("/servers/{id}/command", function ($params) use ($app, $container) {
            $serverModel = $container->make(\App\Models\Server::class);
            $server = $serverModel->findById($params["id"]);
            
            if (!$server) {
                http_response_code(404);
                echo json_encode(["error" => "Not found"]);
                exit;
            }
            
            $input = $app->router()->getRouteParams();
            $command = $input["command"] ?? "";
            
            if ($command) {
                $app->db()->execute(
                    "INSERT INTO server_commands (server_uuid, command, status, created_at) VALUES (?, ?, \"pending\", NOW())",
                    [$server["uuid"], $command]
                );
            }
            
            echo json_encode(["success" => true]);
        });

        // Node API (admin only)
        $router->get("/nodes", function () use ($app, $container) {
            if ($app->session()->get("role") !== "owner" && $app->session()->get("role") !== "admin") {
                http_response_code(403);
                exit;
            }
            
            $nodes = $container->make(\App\Models\Node::class)->getAll();
            header("Content-Type: application/json");
            echo json_encode($nodes);
        });

        // Tickets API
        $router->get("/tickets", function () use ($app, $container) {
            $ticketModel = $container->make(\App\Models\Ticket::class);
            $userId = $app->session()->get("user_id");
            $role = $app->session()->get("role");
            
            $filters = [];
            if ($role !== "owner" && $role !== "admin" && $role !== "support") {
                $filters["user_id"] = $userId;
            }
            
            $result = $ticketModel->getAll($filters);
            header("Content-Type: application/json");
            echo json_encode($result);
        });

        $router->post("/tickets", function () use ($app, $container) {
            $input = $app->router()->getRouteParams();
            
            $validator = Validator::make($input, [
                "subject" => "required|min:5|max:255",
                "message" => "required|min:10",
                "priority" => "in:low,normal,high,urgent",
            ]);
            
            if (!$validator->validate()) {
                http_response_code(422);
                echo json_encode(["errors" => $validator->errors()]);
                exit;
            }
            
            $ticketModel = $container->make(\App\Models\Ticket::class);
            $ticketId = $ticketModel->create([
                "user_id" => $app->session()->get("user_id"),
                "subject" => $input["subject"],
                "priority" => $input["priority"] ?? "normal",
            ]);
            
            $ticketModel->addMessage($ticketId, $app->session()->get("user_id"), $input["message"]);
            
            header("Content-Type: application/json");
            echo json_encode(["success" => true, "ticket_id" => $ticketId]);
        });
    });
});

// Admin/Owner only API endpoints
$router->group("/api/v1", function ($router) use ($app, $container) {
    $router->middleware(function ($request, $next) use ($app) {
        if (!$app->session()->has("user_id")) {
            http_response_code(401);
            echo json_encode(["error" => "Unauthorized"]);
            exit;
        }
        if ($app->session()->get("role") !== "owner" && $app->session()->get("role") !== "admin") {
            http_response_code(403);
            echo json_encode(["error" => "Forbidden"]);
            exit;
        }
        return $next($request);
    });

    // Orders API
    $router->get("/orders", function () use ($app, $container) {
        $orderModel = $container->make(\App\Models\Order::class);
        $page = (int)($_GET["page"] ?? 1);
        $filters = [
            "status" => $_GET["status"] ?? "",
            "package_id" => $_GET["package_id"] ?? "",
            "search" => $_GET["search"] ?? "",
        ];
        $result = $orderModel->getAll($filters, $page, 50);
        header("Content-Type: application/json");
        echo json_encode($result);
    });

    $router->get("/orders/{id}", function ($params) use ($app, $container) {
        $orderModel = $container->make(\App\Models\Order::class);
        $order = $orderModel->findById($params["id"]);
        if (!$order) {
            http_response_code(404);
            echo json_encode(["error" => "Not found"]);
            exit;
        }
        header("Content-Type: application/json");
        echo json_encode($order);
    });

    $router->put("/orders/{id}", function ($params) use ($app, $container) {
        $orderModel = $container->make(\App\Models\Order::class);
        $input = $app->router()->getRouteParams();
        
        $allowedFields = ["status", "notes"];
        $updateData = [];
        foreach ($allowedFields as $field) {
            if (isset($input[$field])) {
                $updateData[$field] = $input[$field];
            }
        }
        
        if ($updateData) {
            $orderModel->update($params["id"], $updateData);
        }
        
        header("Content-Type: application/json");
        echo json_encode(["success" => true]);
    });

    // Settings API
    $router->put("/settings", function () use ($app, $container) {
        $input = $app->router()->getRouteParams();
        $config = $app->config();
        
        // In a real implementation, this would save to config file or database
        // For now, we just acknowledge
        header("Content-Type: application/json");
        echo json_encode(["success" => true, "message" => "Settings saved (requires config file write implementation)"]);
    });

    // System API
    $router->get("/system/time", function () use ($app) {
        header("Content-Type: application/json");
        echo json_encode(["timestamp" => time()]);
    });

    $router->post("/system/clear-cache", function () use ($app) {
        // Clear various caches
        $cacheDirs = [
            __DIR__ . "/../../storage/cache",
            __DIR__ . "/../../storage/views",
        ];
        foreach ($cacheDirs as $dir) {
            if (is_dir($dir)) {
                $files = glob($dir . "/*");
                foreach ($files as $file) {
                    if (is_file($file)) unlink($file);
                }
            }
        }
        header("Content-Type: application/json");
        echo json_encode(["success" => true]);
    });

    $router->post("/system/run-migrations", function () use ($app) {
        // Run pending migrations
        $migrationModel = $container->make(\App\Models\Migration::class);
        $migrationModel->runPending();
        header("Content-Type: application/json");
        echo json_encode(["success" => true]);
    });

    $router->post("/system/csrf-token", function () use ($app) {
        $token = $app->csrf()->regenerate();
        header("Content-Type: application/json");
        echo json_encode(["success" => true, "token" => $token]);
    });
});