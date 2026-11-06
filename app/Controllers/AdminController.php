<?php

namespace App\Controllers;

use App\Core\Application;
use App\Models\User;
use App\Models\Server;
use App\Models\Node;
use App\Models\Package;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\Backup;
use App\Models\PlatformStatus;
use App\Validation\Validator;
use App\Helpers\Session;

class AdminController
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
        $this->checkPermission('admin.dashboard.view');
        
        $serverStats = $this->serverModel->getStats();
        $userStats = $this->userModel->getStats();
        $nodeStats = $this->nodeModel->getStats();
        $ticketStats = $this->ticketModel->getStats();
        $orderStats = $this->orderModel->getStats();
        
        $recentServers = $this->serverModel->getAll([], 1, 10);
        $recentOrders = $this->orderModel->getAll([], 1, 10);
        $openTickets = $this->ticketModel->getAll(['status' => 'open'], 1, 10);

        $this->render('admin/dashboard', [
            'server_stats' => $serverStats,
            'user_stats' => $userStats,
            'node_stats' => $nodeStats,
            'ticket_stats' => $ticketStats,
            'order_stats' => $orderStats,
            'recent_servers' => $recentServers['data'],
            'recent_orders' => $recentOrders['data'],
            'open_tickets' => $openTickets['data'],
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function users(array $params = []): void
    {
        $this->checkPermission('admin.customers.view');
        
        $page = (int)($_GET['page'] ?? 1);
        $filters = [
            'role' => $_GET['role'] ?? '',
            'status' => $_GET['status'] ?? '',
            'search' => $_GET['search'] ?? '',
        ];
        
        $result = $this->userModel->getAll($filters, $page);
        
        $this->render('admin/users', [
            'users' => $result['data'],
            'pagination' => $result,
            'filters' => $filters,
            'roles' => $this->userModel->getRoles(),
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function servers(array $params = []): void
    {
        $this->checkPermission('admin.servers.view');
        
        $page = (int)($_GET['page'] ?? 1);
        $filters = [
            'status' => $_GET['status'] ?? '',
            'node_id' => $_GET['node_id'] ?? '',
            'software' => $_GET['software'] ?? '',
            'search' => $_GET['search'] ?? '',
        ];
        
        $result = $this->serverModel->getAll($filters, $page);
        $nodes = $this->nodeModel->getAll();
        
        $this->render('admin/servers', [
            'servers' => $result['data'],
            'pagination' => $result,
            'nodes' => $nodes,
            'filters' => $filters,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function serverAction(array $params = []): void
    {
        $action = $params['action'] ?? '';
        $serverId = $params['id'] ?? 0;
        
        $server = $this->serverModel->findById($serverId);
        if (!$server) {
            http_response_code(404);
            exit;
        }
        
        switch ($action) {
            case 'start':
                $this->checkPermission('admin.servers.start');
                $this->sendCommand($server['uuid'], 'start');
                break;
            case 'stop':
                $this->checkPermission('admin.servers.stop');
                $this->sendCommand($server['uuid'], 'stop');
                break;
            case 'restart':
                $this->checkPermission('admin.servers.restart');
                $this->sendCommand($server['uuid'], 'restart');
                break;
            case 'suspend':
                $this->checkPermission('admin.servers.suspend');
                $this->serverModel->update($serverId, ['status' => 'suspended']);
                break;
            case 'unsuspend':
                $this->checkPermission('admin.servers.suspend');
                $this->serverModel->update($serverId, ['status' => 'offline']);
                break;
            case 'delete':
                $this->checkPermission('admin.servers.delete');
                $this->serverModel->delete($serverId);
                break;
        }
        
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/admin/servers'));
        exit;
    }

    private function sendCommand(string $uuid, string $command): void
    {
        $this->app->db()->execute(
            "INSERT INTO server_commands (server_uuid, command, status, created_at) VALUES (?, ?, 'pending', NOW())",
            [$uuid, $command]
        );
    }

    public function nodes(array $params = []): void
    {
        $this->checkPermission('admin.nodes.view');
        
        $nodes = $this->nodeModel->getAll();
        
        $this->render('admin/nodes', [
            'nodes' => $nodes,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function packages(array $params = []): void
    {
        $this->checkPermission('admin.packages.view');
        
        $packages = $this->packageModel->getWithServersCount();
        
        $this->render('admin/packages', [
            'packages' => $packages,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function packagesCreate(array $params = []): void
    {
        $this->checkPermission('admin.packages.manage');
        
        $this->render('admin/package_create', [
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function packagesStore(array $params = []): void
    {
        $this->checkPermission('admin.packages.manage');
        
        $input = $this->app->router()->getRouteParams();
        
        $validator = Validator::make($input, [
            'name' => 'required|min:3|max:64',
            'ram' => 'required|integer|min:512',
            'cpu' => 'required|integer|min:1',
            'disk' => 'required|integer|min:1',
            'price_monthly' => 'required|numeric|min:0',
            'player_slots' => 'required|integer|min:1',
        ]);
        
        if (!$validator->validate()) {
            $this->packagesCreate($params);
            return;
        }
        
        $this->packageModel->create($input);
        
        header('Location: /admin/packages');
        exit;
    }

    public function packagesEdit(array $params = []): void
    {
        $this->checkPermission('admin.packages.manage');
        
        $package = $this->packageModel->findById($params['id']);
        if (!$package) {
            http_response_code(404);
            exit;
        }
        
        $this->render('admin/package_edit', [
            'package' => $package,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function packagesUpdate(array $params = []): void
    {
        $this->checkPermission('admin.packages.manage');
        
        $input = $this->app->router()->getRouteParams();
        $this->packageModel->update($params['id'], $input);
        
        header('Location: /admin/packages');
        exit;
    }

    public function packagesDelete(array $params = []): void
    {
        $this->checkPermission('admin.packages.manage');
        
        $this->packageModel->delete($params['id']);
        
        header('Location: /admin/packages');
        exit;
    }

    public function orders(array $params = []): void
    {
        $this->checkPermission('admin.orders.view');
        
        $page = (int)($_GET['page'] ?? 1);
        $filters = [
            'status' => $_GET['status'] ?? '',
            'package_id' => $_GET['package_id'] ?? '',
        ];
        
        $result = $this->orderModel->getAll($filters, $page);
        $packages = $this->packageModel->getAll();
        
        $this->render('admin/orders', [
            'orders' => $result['data'],
            'pagination' => $result,
            'packages' => $packages,
            'filters' => $filters,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function tickets(array $params = []): void
    {
        $this->checkPermission('admin.tickets.manage');
        
        $page = (int)($_GET['page'] ?? 1);
        $filters = [
            'status' => $_GET['status'] ?? '',
            'priority' => $_GET['priority'] ?? '',
            'assigned_to' => $_GET['assigned_to'] ?? '',
        ];
        
        $result = $this->ticketModel->getAll($filters, $page);
        $admins = $this->userModel->getAll(['role' => 'admin']);
        
        $this->render('admin/tickets', [
            'tickets' => $result['data'],
            'pagination' => $result,
            'admins' => $admins['data'],
            'filters' => $filters,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function ticketShow(array $params = []): void
    {
        $this->checkPermission('admin.tickets.manage');
        
        $ticket = $this->ticketModel->findById($params['id']);
        if (!$ticket) {
            http_response_code(404);
            exit;
        }
        
        $messages = $this->ticketModel->getMessages($ticket['id']);
        
        $this->render('admin/ticket_show', [
            'ticket' => $ticket,
            'messages' => $messages,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function ticketReply(array $params = []): void
    {
        $this->checkPermission('admin.tickets.manage');
        
        $input = $this->app->router()->getRouteParams();
        $userId = $this->session->get('user_id');
        
        $this->ticketModel->addMessage($params['id'], $userId, $input['message'], true);
        $this->ticketModel->update($params['id'], ['status' => 'in_progress', 'assigned_to' => $userId]);
        
        header('Location: /admin/tickets/' . $params['id']);
        exit;
    }

    public function ticketStatus(array $params = []): void
    {
        $this->checkPermission('admin.tickets.manage');
        
        $input = $this->app->router()->getRouteParams();
        $this->ticketModel->update($params['id'], ['status' => $input['status']]);
        
        header('Location: /admin/tickets/' . $params['id']);
        exit;
    }

    public function platform(array $params = []): void
    {
        $this->checkPermission('admin.platform.maintenance');
        
        $wipStatus = $this->platformStatus->getWipStatus();
        $serversOfflineStatus = $this->platformStatus->getServersOfflineStatus();
        $maintenanceStatus = $this->platformStatus->getMaintenanceStatus();
        
        $this->render('admin/platform', [
            'wip_status' => $wipStatus,
            'servers_offline_status' => $serversOfflineStatus,
            'maintenance_status' => $maintenanceStatus,
            'csrf_token' => $this->app->csrf()->getToken(),
        ]);
    }

    public function platformWip(array $params = []): void
    {
        $this->checkPermission('admin.platform.maintenance');
        
        $input = $this->app->router()->getRouteParams();
        $enabled = isset($input['enabled']);
        $message = $input['message'] ?? '';
        
        $this->platformStatus->setWipStatus($enabled, $message);
        
        header('Location: /admin/platform');
        exit;
    }

    public function platformServersOffline(array $params = []): void
    {
        $this->checkPermission('admin.platform.maintenance');
        
        $input = $this->app->router()->getRouteParams();
        $enabled = isset($input['enabled']);
        $message = $input['message'] ?? '';
        
        $this->platformStatus->setServersOfflineStatus($enabled, $message);
        
        header('Location: /admin/platform');
        exit;
    }

    public function platformMaintenance(array $params = []): void
    {
        $this->checkPermission('admin.platform.maintenance');
        
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
        
        header('Location: /admin/platform');
        exit;
    }

    public function auditLogs(array $params = []): void
    {
        $this->checkPermission('admin.audit_logs.view');
        
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
        
        $this->render('admin/audit_logs', [
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

    private function checkPermission(string $permission): void
    {
        $permissions = $this->session->get('permissions') ?? [];
        $role = $this->session->get('role');
        
        if ($role === 'owner') return;
        
        if (!in_array($permission, $permissions) && !in_array('*', $permissions)) {
            http_response_code(403);
            $this->render('errors/403');
            exit;
        }
    }

    private function render(string $view, array $data = []): void
    {
        extract($data);
        include __DIR__ . "/../../public/pages/{$view}.php";
    }
}
