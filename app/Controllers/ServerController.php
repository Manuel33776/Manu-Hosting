<?php

namespace App\Controllers;

use App\Core\Application;
use App\Models\Server;
use App\Models\Node;
use App\Models\Package;
use App\Models\Backup;
use App\Validation\Validator;
use App\Helpers\Session;

class ServerController
{
    private Application $app;
    private Server $serverModel;
    private Node $nodeModel;
    private Package $packageModel;
    private Backup $backupModel;
    private Session $session;

    public function __construct(Application $app, Server $serverModel, Node $nodeModel, Package $packageModel, Backup $backupModel, Session $session)
    {
        $this->app = $app;
        $this->serverModel = $serverModel;
        $this->nodeModel = $nodeModel;
        $this->packageModel = $packageModel;
        $this->backupModel = $backupModel;
        $this->session = $session;
    }

    public function index(array $params = []): void
    {
        $userId = $this->session->get('user_id');
        $role = $this->session->get('role');
        $page = (int)($_GET['page'] ?? 1);

        if ($role === 'owner' || $role === 'admin') {
            $filters = [
                'status' => $_GET['status'] ?? '',
                'node_id' => $_GET['node_id'] ?? '',
                'search' => $_GET['search'] ?? '',
            ];
            $result = $this->serverModel->getAll($filters, $page);
            $nodes = $this->nodeModel->getAll();
        } else {
            $result = $this->serverModel->getAll(['user_id' => $userId], $page);
            $nodes = [];
        }

        $stats = $this->serverModel->getStats();

        $this->render('customer/servers', [
            'servers' => $result['data'],
            'pagination' => $result,
            'stats' => $stats,
            'nodes' => $nodes,
            'filters' => $_GET,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function create(array $params = []): void
    {
        $packages = $this->packageModel->getAll();
        $nodes = $this->nodeModel->getOnlineNodes();

        $this->render('customer/server_create', [
            'packages' => $packages,
            'nodes' => $nodes,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function store(array $params = []): void
    {
        $input = $this->app->router()->getRouteParams();
        $userId = $this->session->get('user_id');
        $role = $this->session->get('role');

        $validator = Validator::make($input, [
            'name' => 'required|min:3|max:64',
            'package_id' => 'required|integer',
            'node_id' => 'required|integer',
            'version' => 'required',
            'software' => 'required',
            'java_version' => 'required',
        ]);

        if (!$validator->validate()) {
            $this->create($params);
            return;
        }

        $package = $this->packageModel->findById($input['package_id']);
        $node = $this->nodeModel->findById($input['node_id']);

        if (!$package || !$node) {
            // Handle error
            return;
        }

        $serverId = $this->serverModel->create([
            'user_id' => $userId,
            'node_id' => $node['id'],
            'package_id' => $package['id'],
            'name' => $input['name'],
            'version' => $input['version'],
            'software' => $input['software'],
            'java_version' => $input['java_version'],
            'ram' => $package['ram'],
            'cpu' => $package['cpu'],
            'disk' => $package['disk'],
            'port' => $this->assignPort($node['id']),
            'status' => 'creating',
        ]);

        // TODO: Queue installation job

        header('Location: /dashboard/servers/' . $serverId);
        exit;
    }

    private function assignPort(int $nodeId): int
0
    {
        // Find next available port for this node
        $usedPorts = $this->app->db()->query(
            "SELECT port FROM servers WHERE node_id = ? AND port IS NOT NULL",
            [$nodeId]
        );
        
        $used = array_column($usedPorts, 'port');
        $port = 25565;
        
        while (in_array($port, $used)) {
            $port++;
        }
        
        return $port;
    }

    public function show(array $params = []): void
    {
        $server = $this->serverModel->findById($params['id']);
        
        if (!$server) {
            http_response_code(404);
            $this->render('errors/404');
            return;
        }

        $this->checkAccess($server);

        $backups = $this->backupModel->findByServerId($server['id']);
        $idleConfig = $this->serverModel->getIdleShutdownConfig($server['uuid']);

        $this->render('customer/server_show', [
            'server' => $server,
            'backups' => $backups,
            'idle_config' => $idleConfig,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    private function checkAccess(array $server): void
    {
        $userId = $this->session->get('user_id');
        $role = $this->session->get('role');

        if ($role !== 'owner' && $role !== 'admin' && $server['user_id'] != $userId) {
            http_response_code(403);
            $this->render('errors/403');
            exit;
        }
    }

    public function start(array $params = []): void
    {
        $server = $this->serverModel->findById($params['id']);
        $this->checkAccess($server);
        
        $this->sendCommand($server['uuid'], 'start');
        header('Location: ' . $_SERVER['HTTP_REFERER'] ?? '/dashboard');
        exit;
    }

    public function stop(array $params = []): void
    {
        $server = $this->serverModel->findById($params['id']);
        $this->checkAccess($server);
        
        $this->sendCommand($server['uuid'], 'stop');
        header('Location: ' . $_SERVER['HTTP_REFERER'] ?? '/dashboard');
        exit;
    }

    public function restart(array $params = []): void
    {
        $server = $this->serverModel->findById($params['id']);
        $this->checkAccess($server);
        
        $this->sendCommand($server['uuid'], 'restart');
        header('Location: ' . $_SERVER['HTTP_REFERER'] ?? '/dashboard');
        exit;
    }

    public function console(array $params = []): void
    {
        $server = $this->serverModel->findById($params['id']);
        $this->checkAccess($server);
        
        $this->render('customer/server_console', [
            'server' => $server,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function sendCommand(array $params = []): void
    {
        $server = $this->serverModel->findById($params['id']);
        $this->checkAccess($server);
        
        $command = $_POST['command'] ?? '';
        if ($command) {
            $this->sendCommandToServer($server['uuid'], $command);
        }
        
        if ($this->isAjax()) {
            echo json_encode(['success' => true]);
        } else {
            header('Location: ' . $_SERVER['HTTP_REFERER'] ?? '/dashboard/servers/' . $params['id']);
        }
        exit;
    }

    private function sendCommand(string $uuid, string $command): void
    {
        // TODO: Send command to node agent via API
        $this->app->db()->execute(
            "INSERT INTO server_commands (server_uuid, command, status, created_at) VALUES (?, ?, 'pending', NOW())",
            [$uuid, $command]
        );
    }

    private function sendCommandToServer(string $uuid, string $command): void
    {
        // This would communicate with the Windows Node Agent
        // For now, just log it
        error_log("Command for server {$uuid}: {$command}");
    }

    private function isAjax(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    public function logs(array $params = []): void
    {
        $server = $this->serverModel->findById($params['id']);
        $this->checkAccess($server);
        
        // TODO: Fetch logs from node agent
        $logs = [];
        
        $this->render('customer/server_logs', [
            'server' => $server,
            'logs' => $logs,
        ]);
    }

    public function players(array $params = []): void
    {
        $server = $this->serverModel->findById($params['id']);
        $this->checkAccess($server);
        
        // TODO: Fetch players from node agent/bridge
        $players = [];
        
        $this->render('customer/server_players', [
            'server' => $server,
            'players' => $players,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function files(array $params = []): void
    {
        $server = $this->serverModel->findById($params['id']);
        $this->checkAccess($server);
        
        $path = $_GET['path'] ?? '/';
        
        // TODO: Fetch files from node agent
        $files = [];
        
        $this->render('customer/server_files', [
            'server' => $server,
            'files' => $files,
            'current_path' => $path,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function backups(array $params = []): void
    {
        $server = $this->serverModel->findById($params['id']);
        $this->checkAccess($server);
        
        $backups = $this->backupModel->findByServerId($server['id']);
        
        $this->render('customer/server_backups', [
            'server' => $server,
            'backups' => $backups,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function createBackup(array $params = []): void
    {
        $server = $this->serverModel->findById($params['id']);
        $this->checkAccess($server);
        
        $backupId = $this->backupModel->create([
            'server_id' => $server['id'],
            'type' => 'manual',
            'status' => 'pending',
        ]);
        
        // TODO: Queue backup job on node agent
        
        header('Location: /dashboard/servers/' . $params['id'] . '/backups');
        exit;
    }

    public function schedule(array $params = []): void
    {
        $server = $this->serverModel->findById($params['id']);
        $this->checkAccess($server);
        
        $this->render('customer/server_schedule', [
            'server' => $server,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function settings(array $params = []): void
    {
        $server = $this->serverModel->findById($params['id']);
        $this->checkAccess($server);
        
        $idleConfig = $this->serverModel->getIdleShutdownConfig($server['uuid']);
        
        $this->render('customer/server_settings', [
            'server' => $server,
            'idle_config' => $idleConfig,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function updateSettings(array $params = []): void
    {
        $server = $this->serverModel->findById($params['id']);
        $this->checkAccess($server);
        
        $input = $this->app->router()->getRouteParams();
        
        // Update idle shutdown settings
        if (isset($input['idle_shutdown_enabled'])) {
            $this->serverModel->setIdleShutdownConfig(
                $server['uuid'],
                (bool)$input['idle_shutdown_enabled'],
                (int)($input['idle_shutdown_timeout'] ?? 60)
            );
        }
        
        header('Location: /dashboard/servers/' . $params['id'] . '/settings');
        exit;
    }

    public function delete(array $params = []): void
    {
        $server = $this->serverModel->findById($params['id']);
        $this->checkAccess($server);
        
        $confirm = $_POST['confirm_delete'] ?? '';
        if ($confirm !== $server['name']) {
            // Show confirmation page
            $this->render('customer/server_delete_confirm', [
                'server' => $server,
                'csrf_token' => $this->app->csrf()->getToken(),
            ]);
            return;
        }
        
        // TODO: Delete server files on node
        $this->serverModel->delete($server['id']);
        
        header('Location: /dashboard');
        exit;
    }

    private function render(string $view, array $data = []): void
    {
        extract($data);
        include __DIR__ . "/../../public/pages/{$view}.php";
    }
}
