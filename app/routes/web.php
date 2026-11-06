<?php

use App\Core\Application;
use App\Controllers\AuthController;
use App\Controllers\ServerController;
use App\Controllers\AdminController;
use App\Controllers\OwnerController;

$app = Application::getInstance();
$router = $app->router();

$container = $app->container();

// Public routes
$router->get('/', function () use ($app) {
    $wip = $app->config()->get('work_in_progress.enabled');
    $serversOffline = $app->config()->get('servers_offline.enabled');
    $maintenance = $app->config()->get('maintenance.enabled');
    
    include __DIR__ . '/../../public/pages/public/home.php';
});

$router->get('/features', function () use ($app) {
    include __DIR__ . '/../../public/pages/public/features.php';
});

$router->get('/pricing', function () use ($app) {
    $packages = $container->make(\App\Models\Package::class)->getAll();
    include __DIR__ . '/../../public/pages/public/pricing.php';
});

$router->get('/about', function () {
    include __DIR__ . '/../../public/pages/public/about.php';
});

$router->get('/contact', function () {
    include __DIR__ . '/../../public/pages/public/contact.php';
});

$router->get('/status', function () use ($app) {
    $platformStatus = $container->make(\App\Models\PlatformStatus::class);
    $status = $platformStatus->getOverallStatus();
    include __DIR__ . '/../../public/pages/public/status.php';
});

$router->get('/impressum', function () {
    include __DIR__ . '/../../public/pages/public/impressum.php';
});

$router->get('/datenschutz', function () {
    include __DIR__ . '/../../public/pages/public/datenschutz.php';
});

$router->get('/agb', function () {
    include __DIR__ . '/../../public/pages/public/agb.php';
});

$router->get('/widerruf', function () {
    include __DIR__ . '/../../public/pages/public/widerruf.php';
});

// Auth routes
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/logout', [AuthController::class, 'logout']);
$router->get('/password/forgot', [AuthController::class, 'showForgotPassword']);
$router->post('/password/forgot', [AuthController::class, 'forgotPassword']);
$router->get('/password/reset/{token}', [AuthController::class, 'showResetPassword']);
$router->post('/password/reset', [AuthController::class, 'resetPassword']);

// Customer dashboard routes (auth required)
$router->group('/dashboard', function ($router) {
    $router->get('', function () use ($app) {
        $user = $container->make(\App\Models\User::class)->findById($app->session()->get('user_id'));
        $servers = $container->make(\App\Models\Server::class)->findByUserId($app->session()->get('user_id'));
        include __DIR__ . '/../../public/pages/customer/dashboard.php';
    })->auth(true);
    
    $router->get('/servers', [ServerController::class, 'index'])->auth(true);
    $router->get('/servers/create', [ServerController::class, 'create'])->auth(true);
    $router->post('/servers', [ServerController::class, 'store'])->auth(true);
    $router->get('/servers/{id}', [ServerController::class, 'show'])->auth(true);
    $router->post('/servers/{id}/start', [ServerController::class, 'start'])->auth(true);
    $router->post('/servers/{id}/stop', [ServerController::class, 'stop'])->auth(true);
    $router->post('/servers/{id}/restart', [ServerController::class, 'restart'])->auth(true);
    $router->get('/servers/{id}/console', [ServerController::class, 'console'])->auth(true);
    $router->post('/servers/{id}/console', [ServerController::class, 'sendCommand'])->auth(true);
    $router->get('/servers/{id}/logs', [ServerController::class, 'logs'])->auth(true);
    $router->get('/servers/{id}/players', [ServerController::class, 'players'])->auth(true);
    $router->get('/servers/{id}/files', [ServerController::class, 'files'])->auth(true);
    $router->get('/servers/{id}/backups', [ServerController::class, 'backups'])->auth(true);
    $router->post('/servers/{id}/backups', [ServerController::class, 'createBackup'])->auth(true);
    $router->get('/servers/{id}/schedule', [ServerController::class, 'schedule'])->auth(true);
    $router->get('/servers/{id}/settings', [ServerController::class, 'settings'])->auth(true);
    $router->post('/servers/{id}/settings', [ServerController::class, 'updateSettings'])->auth(true);
    $router->get('/servers/{id}/delete', [ServerController::class, 'delete'])->auth(true);
    $router->post('/servers/{id}/delete', [ServerController::class, 'delete'])->auth(true);
})->auth(true);

// Admin dashboard routes (admin+ required)
$router->group('/admin', function ($router) {
    $router->get('', [AdminController::class, 'index'])->auth(true, ['admin', 'support']);
    $router->get('/users', [AdminController::class, 'users'])->auth(true, ['admin', 'support']);
    $router->get('/servers', [AdminController::class, 'servers'])->auth(true, ['admin']);
    $router->post('/servers/{id}/{action}', [AdminController::class, 'serverAction'])->auth(true, ['admin']);
    $router->get('/nodes', [AdminController::class, 'nodes'])->auth(true, ['admin']);
    $router->get('/packages', [AdminController::class, 'packages'])->auth(true, ['admin']);
    $router->get('/packages/create', [AdminController::class, 'packagesCreate'])->auth(true, ['admin']);
    $router->post('/packages', [AdminController::class, 'packagesStore'])->auth(true, ['admin']);
    $router->get('/packages/{id}/edit', [AdminController::class, 'packagesEdit'])->auth(true, ['admin']);
    $router->post('/packages/{id}', [AdminController::class, 'packagesUpdate'])->auth(true, ['admin']);
    $router->post('/packages/{id}/delete', [AdminController::class, 'packagesDelete'])->auth(true, ['admin']);
    $router->get('/orders', [AdminController::class, 'orders'])->auth(true, ['admin', 'support']);
    $router->get('/tickets', [AdminController::class, 'tickets'])->auth(true, ['admin', 'support']);
    $router->get('/tickets/{id}', [AdminController::class, 'ticketShow'])->auth(true, ['admin', 'support']);
    $router->post('/tickets/{id}/reply', [AdminController::class, 'ticketReply'])->auth(true, ['admin', 'support']);
    $router->post('/tickets/{id}/status', [AdminController::class, 'ticketStatus'])->auth(true, ['admin', 'support']);
    $router->get('/platform', [AdminController::class, 'platform'])->auth(true, ['admin']);
    $router->post('/platform/wip', [AdminController::class, 'platformWip'])->auth(true, ['admin']);
    $router->post('/platform/servers-offline', [AdminController::class, 'platformServersOffline'])->auth(true, ['admin']);
    $router->post('/platform/maintenance', [AdminController::class, 'platformMaintenance'])->auth(true, ['admin']);
    $router->get('/audit-logs', [AdminController::class, 'auditLogs'])->auth(true, ['admin']);
})->auth(true, ['admin', 'support']);

// Owner dashboard routes (owner only)
$router->group('/owner', function ($router) {
    $router->get('', [OwnerController::class, 'index'])->auth(true, ['owner']);
    $router->get('/servers', [OwnerController::class, 'servers'])->auth(true, ['owner']);
    $router->post('/servers/{id}/{action}', [OwnerController::class, 'serverAction'])->auth(true, ['owner']);
    $router->get('/customers', [OwnerController::class, 'customers'])->auth(true, ['owner']);
    $router->get('/admins', [OwnerController::class, 'admins'])->auth(true, ['owner']);
    $router->post('/admins', [OwnerController::class, 'adminCreate'])->auth(true, ['owner']);
    $router->post('/admins/{id}', [OwnerController::class, 'adminUpdate'])->auth(true, ['owner']);
    $router->post('/admins/{id}/delete', [OwnerController::class, 'adminDelete'])->auth(true, ['owner']);
    $router->post('/admins/{id}/reset-password', [OwnerController::class, 'adminResetPassword'])->auth(true, ['owner']);
    $router->get('/packages', [OwnerController::class, 'packages'])->auth(true, ['owner']);
    $router->get('/nodes', [OwnerController::class, 'nodes'])->auth(true, ['owner']);
    $router->get('/resources', [OwnerController::class, 'resources'])->auth(true, ['owner']);
    $router->get('/maintenance', [OwnerController::class, 'maintenance'])->auth(true, ['owner']);
    $router->post('/maintenance/wip', [OwnerController::class, 'maintenanceWip'])->auth(true, ['owner']);
    $router->post('/maintenance/servers-offline', [OwnerController::class, 'maintenanceServersOffline'])->auth(true, ['owner']);
    $router->post('/maintenance/toggle', [OwnerController::class, 'maintenanceToggle'])->auth(true, ['owner']);
    $router->get('/email', [OwnerController::class, 'email'])->auth(true, ['owner']);
    $router->post('/email', [OwnerController::class, 'emailUpdate'])->auth(true, ['owner']);
    $router->post('/email/test', [OwnerController::class, 'emailTest'])->auth(true, ['owner']);
    $router->get('/inventory', [OwnerController::class, 'inventory'])->auth(true, ['owner']);
    $router->get('/anticheat', [OwnerController::class, 'anticheat'])->auth(true, ['owner']);
    $router->get('/backups', [OwnerController::class, 'backups'])->auth(true, ['owner']);
    $router->get('/support', [OwnerController::class, 'support'])->auth(true, ['owner']);
    $router->get('/orders', [OwnerController::class, 'orders'])->auth(true, ['owner']);
    $router->get('/audit-logs', [OwnerController::class, 'auditLogs'])->auth(true, ['owner']);
    $router->get('/settings', [OwnerController::class, 'settings'])->auth(true, ['owner']);
})->auth(true, ['owner']);

// Maintenance page (accessible during maintenance)
$router->get('/maintenance', function () use ($app) {
    $maintenance = $app->config()->get('maintenance');
    include __DIR__ . '/../../public/pages/public/maintenance.php';
});

// 404 handler
$router->any('{*path}', function () {
    http_response_code(404);
    include __DIR__ . '/../../public/pages/public/404.php';
});
