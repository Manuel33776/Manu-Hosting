<?php

namespace App\Controllers;

use App\Core\Application;
use App\Models\User;
use App\Models\Server;
use App\Models\Node;
use App\Models\Package;
use App\Models\Order;
use App.Models\Ticket;
use App\Models\Backup;
use App\Models\PlatformStatus;
use App\Validation\Validator;
use App\Helpers\Session;

class OwnerController
{
    private Application $app;
    private User $userModel;
    private Server $serverModel;
    private Node $nodeModel;
    private Package $packageModel;
    private Order $orderModel;
    private Ticket $ticketModel;
    private Backup $backupModel;
    private PlatformStatus $platformStatus;
    private Session $session;

    public function __construct(Application $app, User $userModel, Server $serverModel, Node $nodeModel, Package $packageModel, Order $orderModel, Ticket $ticketModel, Backup $backupModel, PlatformStatus $platformStatus, Session $session)
    {
        $this->app = $app;
        $this->userModel = $userModel;
        $this->serverModel = $serverModel;
        $this->nodeModel = $nodeModel;
        $this->packageModel = $packageModel;
        $this->orderModel = $orderModel;
        $this->ticketModel = $ticketModel;
        $this->backupModel = $backupModel;
        $this->platformStatus = $platformStatus;
        $this->session = $session;
    }

    public function index(array $params = []): void
    {
        $this->checkOwner();
        
        $serverStats = $this->serverModel->getStats();
        $userStats = $this->userModel->getStats();
        $nodeStats = $this->nodeModel->getStats();
        $ticketStats = $this->ticketModel->getStats();
        $orderStats = $this->orderModel->getStats();
        $backupStats = $this->backupModel->getStats();
        
        $maintenanceStatus = $this->platformStatus->getMaintenanceStatus();
        $wipStatus = $this->platformStatus->getWipStatus();
        $serversOfflineStatus = $this->platformStatus->getServersOfflineStatus();
        
        $offlineTimer = null;
        if ($maintenanceStatus['enabled'] && $maintenanceStatus['started_at']) {
            $startTime = strtotime($maintenanceStatus['started_at']);
            $offlineTimer = time() - $startTime;
        }
        
        $plannedEndCountdown = null;
        if ($maintenanceStatus['enabled'] && $maintenanceStatus['planned_end_at']) {
            $endTime = strtotime($maintenanceStatus['planned_end_at']);
            $plannedEndCountdown = $endTime - time();
            if ($plannedEndCountdown < 0) $plannedEndCountdown = 0;
        }
        
        $this->render('owner/dashboard', [
            'server_stats' => $serverStats,
            'user_stats' => $userStats,
            'node_stats' => $nodeStats,
            'ticket_stats' => $ticketStats,
            'order_stats' => $orderStats,
            'backup_stats' => $backupStats,
            'maintenance_status' => $maintenanceStatus,
            'wip_status' => $wipStatus,
            'servers_offline_status' => $serversOfflineStatus,
            'offline_timer' => $offlineTimer,
            'planned_end_countdown' => $plannedEndCountdown,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function servers(array $params = []): void
    {
        $this->checkOwner();
        
        $page = (int)($_GET['page'] ?? 1);
        $filters = [
            'status' => $_GET['status'] ?? '',
            'node_id' => $_GET['node_id'] ?? '',
            'software' => $_GET['software'] ?? '',
            'search' => $_GET['search'] ?? '',
        ];
        
        $result = $this->serverModel->getAll($filters, $page);
        $nodes = $this->nodeModel->getAll();
        
        $this->render('owner/servers', [
            'servers' => $result['data'],
            'pagination' => $result,
            'nodes' => $nodes,
            'filters' => $filters,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function serverAction(array $params = []): void
    {
        $this->checkOwner();
        
        $action = $params['action'] ?? '';
        $serverId = $params['id'] ?? 0;
        
        $server = $this->serverModel->findById($serverId);
        if (!$server) {
            http_response_code(404);
            exit;
        }
        
        switch ($action) {
            case 'start':
                $this->sendCommand($server['uuid'], 'start');
                break;
            case 'stop':
                $this->sendCommand($server['uuid'], 'stop');
                break;
            case 'restart':
                $this->sendCommand($server['uuid'], 'restart');
                break;
            case 'suspend':
                $this->serverModel->update($serverId, ['status' => 'suspended']);
                break;
            case 'unsuspend':
                $this->serverModel->update($serverId, ['status' => 'offline']);
                break;
            case 'delete':
                $confirm = $_POST['confirm_delete'] ?? '';
                if ($confirm !== $server['name']) {
                    $this->render('owner/server_delete_confirm', [
                        'server' => $server,
                        'csrf_token' => $this->app->csrf()->getToken(),
                    ]);
                    return;
                }
                $this->serverModel->delete($serverId);
                break;
        }
        
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/owner/servers'));
        exit;
    }

    private function sendCommand(string $uuid, string $command): void
    {
        $this->app->db()->execute(
            "INSERT INTO server_commands (server_uuid, command, status, created_at) VALUES (?, ?, 'pending', NOW())",
            [$uuid, $command]
        );
    }

    public function customers(array $params = []): void
    {
        $this->checkOwner();
        
        $page = (int)($_GET['page'] ?? 1);
        $filters = [
            'role' => $_GET['role'] ?? '',
            'status' => $_GET['status'] ?? '',
            'search' => $_GET['search'] ?? '',
        ];
        
        $result = $this->userModel->getAll($filters, $page);
        
        $this->render('owner/customers', [
            'customers' => $result['data'],
            'pagination' => $result,
            'filters' => $filters,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function admins(array $params = []): void
    {
        $this->checkOwner();
        
        $page = (int)($_GET['page'] ?? 1);
        $result = $this->userModel->getAll(['role' => ['admin', 'support']], $page);
        
        $this->render('owner/admins', [
            'admins' => $result['data'],
            'pagination' => $result,
            'roles' => ['admin', 'support'],
            'permissions' => $this->userModel->getPermissions(),
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function adminCreate(array $params = []): void
    {
        $this->checkOwner();
        
        $input = $this->app->router()->getRouteParams();
        
        $validator = Validator::make($input, [
            'username' => 'required|alpha_dash|min:3|max:32|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|password|confirmed',
            'role' => 'required|in:admin,support',
            'permissions' => 'array',
        ]);
        
        if (!$validator->validate()) {
            if ($this->isAjax()) {
                http_response_code(422);
                echo json_encode(['errors' => $validator->errors()]);
            } else {
                $_SESSION['errors'] = $validator->errors();
                $_SESSION['old'] = $input;
                header('Location: /owner/admins');
            }
            exit;
        }
        
        $permissions = $input['permissions'] ?? [];
        $allPermissions = $this->userModel->getPermissions();
        $rolePermissions = $allPermissions[$input['role']] ?? [];
        
        $filteredPermissions = array_intersect($permissions, $rolePermissions);
        
        $this->userModel->create([
            'username' => $input['username'],
            'email' => $input['email'],
            'password' => $input['password'],
            'role' => $input['role'],
            'status' => 'active',
            'permissions' => json_encode($filteredPermissions),
            'email_verified' => 1,
        ]);
        
        if ($this->isAjax()) {
            echo json_encode(['success' => true, 'message' => 'Administrator erstellt']);
        } else {
            header('Location: /owner/admins');
        }
        exit;
    }

    public function adminUpdate(array $params = []): void
    {
        $this->checkOwner();
        
        $admin = $this->userModel->findById($params['id']);
        if (!$admin || !in_array($admin['role'], ['admin', 'support'])) {
            http_response_code(404);
            exit;
        }
        
        $input = $this->app->router()->getRouteParams();
        
        $updateData = [];
        if (!empty($input['email'])) $updateData['email'] = $input['email'];
        if (!empty($input['password'])) $updateData['password'] = $input['password'];
        if (isset($input['status'])) $updateData['status'] = $input['status'];
        if (isset($input['permissions'])) {
            $allPermissions = $this->userModel->getPermissions();
            $rolePermissions = $allPermissions[$admin['role']] ?? [];
            $updateData['permissions'] = json_encode(array_intersect($input['permissions'], $rolePermissions));
        }
        
        if ($updateData) {
            $this->userModel->update($admin['id'], $updateData);
        }
        
        if ($this->isAjax()) {
            echo json_encode(['success' => true]);
        } else {
            header('Location: /owner/admins');
        }
        exit;
    }

    public function adminDelete(array $params = []): void
    {
        $this->checkOwner();
        
        $admin = $this->userModel->findById($params['id']);
        if (!$admin || !in_array($admin['role'], ['admin', 'support'])) {
            http_response_code(404);
            exit;
        }
        
        $this->userModel->delete($admin['id']);
        
        if ($this->isAjax()) {
            echo json_encode(['success' => true]);
        } else {
            header('Location: /owner/admins');
        }
        exit;
    }

    public function adminResetPassword(array $params = []): void
    {
        $this->checkOwner();
        
        $admin = $this->userModel->findById($params['id']);
        if (!$admin) {
            http_response_code(404);
            exit;
        }
        
        $tempPassword = bin2hex(random_bytes(8));
        $this->userModel->update($admin['id'], ['password' => $tempPassword]);
        
        if ($this->isAjax()) {
            echo json_encode(['success' => true, 'temp_password' => $tempPassword]);
        } else {
            $_SESSION['temp_password'] = $tempPassword;
            header('Location: /owner/admins');
        }
        exit;
    }

    public function packages(array $params = []): void
    {
        $this->checkOwner();
        
        $packages = $this->packageModel->getWithServersCount();
        
        $this->render('owner/packages', [
            'packages' => $packages,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function nodes(array $params = []): void
    {
        $this->checkOwner();
        
        $nodes = $this->nodeModel->getAll();
        $nodeStats = $this->nodeModel->getStats();
        
        $this->render('owner/nodes', [
            'nodes' => $nodes,
            'node_stats' => $nodeStats,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function resources(array $params = []): void
    {
        $this->checkOwner();
        
        $nodes = $this->nodeModel->getAll();
        $serverStats = $this->serverModel->getStats();
        
        $servers = $this->serverModel->getAll([], 1, 100);
        
        $this->render('owner/resources', [
            'nodes' => $nodes,
            'server_stats' => $serverStats,
            'servers' => $servers['data'],
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function maintenance(array $params = []): void
    {
        $this->checkOwner();
        
        $maintenanceStatus = $this->platformStatus->getMaintenanceStatus();
        $wipStatus = $this->platformStatus->getWipStatus();
        $serversOfflineStatus = $this->platformStatus->getServersOfflineStatus();
        $maintenanceHistory = $this->platformStatus->getMaintenanceHistory();
        
        $offlineTimer = null;
        if ($maintenanceStatus['enabled'] && $maintenanceStatus['started_at']) {
            $startTime = strtotime($maintenanceStatus['started_at']);
            $offlineTimer = time() - $startTime;
        }
        
        $plannedEndCountdown = null;
        if ($maintenanceStatus['enabled'] && $maintenanceStatus['planned_end_at']) {
            $endTime = strtotime($maintenanceStatus['planned_end_at']);
            $plannedEndCountdown = $endTime - time();
            if ($plannedEndCountdown < 0) $plannedEndCountdown = 0;
        }
        
        $this->render('owner/maintenance', [
            'maintenance_status' => $maintenanceStatus,
            'wip_status' => $wipStatus,
            'servers_offline_status' => $serversOfflineStatus,
            'maintenance_history' => $maintenanceHistory,
            'offline_timer' => $offlineTimer,
            'planned_end_countdown' => $plannedEndCountdown,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function maintenanceWip(array $params = []): void
    {
        $this->checkOwner();
        
        $input = $this->app->router()->getRouteParams();
        $enabled = isset($input['enabled']);
        $message = $input['message'] ?? '';
        
        $this->platformStatus->setWipStatus($enabled, $message);
        
        header('Location: /owner/maintenance');
        exit;
    }

    public function maintenanceServersOffline(array $params = []): void
    {
        $this->checkOwner();
        
        $input = $this->app->router()->getRouteParams();
        $enabled = isset($input['enabled']);
        $message = $input['message'] ?? '';
        
        $this->platformStatus->setServersOfflineStatus($enabled, $message);
        
        header('Location: /owner/maintenance');
        exit;
    }

    public function maintenanceToggle(array $params = []): void
    {
        $this->checkOwner();
        
        $input = $this->app->router()->getRouteParams();
        $enabled = isset($input['enabled']);
        $message = $input['message'] ?? '';
        $plannedEnd = $input['planned_end'] ?? null;
        
        if ($enabled) {
            $this->platformStatus->setMaintenance([
                'enabled' => true,
                'message' => $message,
                'planned_end_at' => $plannedEnd,
            ]);
        } else {
            $this->platformStatus->endMaintenance();
        }
        
        header('Location: /owner/maintenance');
        exit;
    }

    public function email(array $params = []): void
    {
        $this->checkOwner();
        
        $config = $this->app->config()->get('email');
        $config['password'] = '';
        
        $this->render('owner/email', [
            'config' => $config,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function emailUpdate(array $params = []): void
    {
        $this->checkOwner();
        
        $input = $this->app->router()->getRouteParams();
        
        header('Location: /owner/email');
        exit;
    }

    public function emailTest(array $params = []): void
    {
        $this->checkOwner();
        
        if ($this->isAjax()) {
            echo json_encode(['success' => true, 'message' => 'Test-E-Mail gesendet']);
        } else {
            header('Location: /owner/email');
        }
        exit;
    }

    public function inventory(array $params = []): void
    {
        $this->checkOwner();
        
        $inventory = [];
        
        $this->render('owner/inventory', [
            'inventory' => $inventory,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function anticheat(array $params = []): void
    {
        $this->checkOwner();
        
        $alerts = [];
        
        $this->render('owner/anticheat', [
            'alerts' => $alerts,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function backups(array $params = []): void
    {
        $this->checkOwner();
        
        $page = (int)($_GET['page'] ?? 1);
        $result = $this->backupModel->getAll([], $page, 50);
        
        $this->render('owner/backups', [
            'backups' => $result['data'],
            'pagination' => $result,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function support(array $params = []): void
    {
        $this->checkOwner();
        
        $page = (int)($_GET['page'] ?? 1);
        $result = $this->ticketModel->getAll([], $page, 50);
        
        $this->render('owner/support', [
            'tickets' => $result['data'],
            'pagination' => $result,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function orders(array $params = []): void
    {
        $this->checkOwner();
        
        $page = (int)($_GET['page'] ?? 1);
        $result = $this->orderModel->getAll([], $page, 50);
        
        $this->render('owner/orders', [
            'orders' => $result['data'],
            'pagination' => $result,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function auditLogs(array $params = []): void
    {
        $this->checkOwner();
        
        $page = (int)($_GET['page'] ?? 1);
        $perPage = 50;
        $offset = ($page - 1) * $perPage;
        
        $filters = [
            'user_id' => $_GET['user_id'] ?? '',
            'action' => $_GET['action'] ?? '',
            'date_from' => $_GET['date_from'] ?? '',
            'date_to' => $_GET['date_to'] ?? '',
        ];
        
        $where = [];
        $params = [];
        
        if (!empty($filters['user_id'])) {
            $where[] = 'user_id = ?';
            $params[] = $filters['user_id'];
        }
        if (!empty($filters['action'])) {
            $where[] = 'action LIKE ?';
            $params[] = '%' . $filters['action'] . '%';
        }
        if (!empty($filters['date_from'])) {
            $where[] = 'created_at >= ?';
            $params[] = $filters['date_from'];
        }
        if (!empty($filters['date_to'])) {
            $where[] = 'created_at <= ?';
            $params[] = $filters['date_to'] . ' 23:59:59';
        }
        
        $whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';
        
        $logs = $this->app->db()->query(
            "SELECT al.*, u.username FROM audit_logs al LEFT JOIN users u ON al.user_id = u.id {$whereSql} ORDER BY al.created_at DESC LIMIT ? OFFSET ?",
            array_merge($params, [$perPage, $offset])
        );
        
        $total = $this->app->db()->queryOne(
            "SELECT COUNT(*) as count FROM audit_logs {$whereSql}",
            $params
        );
        
        $this->render('owner/audit_logs', [
            'logs' => $logs,
            'pagination' => [
                'data' => $logs,
                'total' => $total['count'] ?? 0,
                'page' => $page,
                'per_page' => $perPage,
                'last_page' => ceil(($total['count'] ?? 0) / $perPage),
            ],
            'filters' => $filters,
        ]);
    }

    public function settings(array $params = []): void
    {
        $this->checkOwner();
        
        $config = $this->app->config()->all();
        
        $this->render('owner/settings', [
            'config' => $config,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    private function checkOwner(): void
    {
        $role = $this->session->get('role');
        if ($role !== 'owner') {
            http_response_code(403);
            $this->render('errors/403');
            exit;
        }
    }

    private function isAjax(): bool
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    private function render(string $view, array $data = []): void
    {
        extract($data);
        include __DIR__ . "/../../public/pages/{$view}.php";
    }
}
