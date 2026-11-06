<?php

namespace App\Core;

use App\Core\Config;
use App\Core\Database;
use App\Core\Router;
use App\Core\Container;
use App\Core\Events;
use App\Helpers\Session;
use App\Security\Csrf;
use App\Security\RateLimiter;

class Application
{
    private static ?self $instance = null;
    private Config $config;
    private Database $database;
    private Router $router;
    private Container $container;
    private Events $events;
    private Session $session;
    private Csrf $csrf;
    private RateLimiter $rateLimiter;
    private bool $booted = false;

    private function __construct()
    {
        $this->config = new Config();
        $this->container = new Container();
        $this->events = new Events();
        $this->database = new Database($this->config->get('database'));
        $this->router = new Router($this->container);
        $this->session = new Session($this->database, $this->config->get('session'));
        $this->csrf = new Csrf($this->session);
        $this->rateLimiter = new RateLimiter($this->database, $this->config->get('security.rate_limit'));

        $this->registerCoreServices();
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function boot(): void
    {
        if ($this->booted) {
            return;
        }

        // Set timezone
        date_default_timezone_set($this->config->get('app.timezone'));

        // Start session
        $this->session->start();

        // Register middleware
        $this->registerMiddleware();

        // Load routes
        $this->loadRoutes();

        $this->booted = true;
    }

    public function run(): void
    {
        $this->boot();
        $this->router->dispatch();
    }

    private function registerCoreServices(): void
    {
        $this->container->singleton('config', fn() => $this->config);
        $this->container->singleton('db', fn() => $this->database);
        $this->container->singleton('router', fn() => $this->router);
        $this->container->singleton('events', fn() => $this->events);
        $this->container->singleton('session', fn() => $this->session);
        $this->container->singleton('csrf', fn() => $this->csrf);
        $this->container->singleton('rate_limiter', fn() => $this->rateLimiter);
    }

    private function registerMiddleware(): void
    {
        // Maintenance mode middleware
        $this->router->middleware(function ($request, $next) {
            if ($this->config->get('maintenance.enabled') && !$this->isAllowedInMaintenance()) {
                http_response_code(503);
                $this->renderMaintenancePage();
                exit;
            }
            return $next($request);
        });

        // CSRF protection middleware (for non-API routes)
        $this->router->middleware(function ($request, $next) {
            if (!$this->isApiRoute($request) && !$this->isCsrfExempt($request)) {
                if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
                    $this->csrf->validate();
                }
            }
            return $next($request);
        });

        // Rate limiting middleware
        $this->router->middleware(function ($request, $next) {
            $key = $this->getRateLimitKey($request);
            $limit = $this->getRateLimitConfig($request);
            
            if (!$this->rateLimiter->check($key, $limit['requests'], $limit['window'])) {
                http_response_code(429);
                $this->renderRateLimitPage($limit['window']);
                exit;
            }
            return $next($request);
        });

        // Auth middleware for protected routes
        $this->router->middleware(function ($request, $next) {
            $route = $this->router->getCurrentRoute();
            if ($route && isset($route['auth']) && $route['auth']) {
                if (!$this->session->has('user_id')) {
                    if ($this->isApiRoute($request)) {
                        $this->jsonResponse(['error' => 'Unauthorized'], 401);
                    } else {
                        $this->session->set('redirect_after_login', $_SERVER['REQUEST_URI']);
                        header('Location: /login');
                    }
                    exit;
                }
                
                // Check role permissions
                if (isset($route['roles']) && !in_array($this->session->get('role'), $route['roles'])) {
                    $this->renderForbiddenPage();
                    exit;
                }
            }
            return $next($request);
        });
    }

    private function loadRoutes(): void
    {
        require_once __DIR__ . '/../../routes/web.php';
        require_once __DIR__ . '/../../routes/api.php';
    }

    private function isAllowedInMaintenance(): bool
    {
        $allowedIps = $this->config->get('maintenance.allowed_ips');
        $clientIp = $_SERVER['REMOTE_ADDR'] ?? '';
        
        if (in_array($clientIp, $allowedIps)) {
            return true;
        }

        if ($this->session->has('user_id')) {
            $allowedRoles = $this->config->get('maintenance.allowed_roles');
            $userRole = $this->session->get('role');
            if (in_array($userRole, $allowedRoles)) {
                return true;
            }
        }

        return false;
    }

    private function isApiRoute($request): bool
    {
        $uri = $request['uri'] ?? $_SERVER['REQUEST_URI'];
        return str_starts_with($uri, '/api/');
    }

    private function isCsrfExempt($request): bool
    {
        $uri = $request['uri'] ?? $_SERVER['REQUEST_URI'];
        $exemptRoutes = $this->config->get('security.csrf_exempt_routes');
        
        foreach ($exemptRoutes as $route) {
            $pattern = str_replace('*', '.*', preg_quote($route, '/'));
            if (preg_match('#^' . $pattern . '$#', $uri)) {
                return true;
            }
        }
        return false;
    }

    private function getRateLimitKey($request): string
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $uri = $request['uri'] ?? $_SERVER['REQUEST_URI'];
        return $ip . ':' . $uri;
    }

    private function getRateLimitConfig($request): array
    {
        $uri = $request['uri'] ?? $_SERVER['REQUEST_URI'];
        $limits = $this->config->get('security.rate_limit');
        
        if (str_starts_with($uri, '/login')) return $limits['login'];
        if (str_starts_with($uri, '/register')) return $limits['register'];
        if (str_starts_with($uri, '/api/')) return $limits['api'];
        
        return $limits['default'];
    }

    private function renderMaintenancePage(): void
    {
        $message = $this->config->get('maintenance.message');
        $retryAfter = $this->config->get('maintenance.retry_after');
        header('Retry-After: ' . $retryAfter);
        ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wartung - Manu Hosting</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>
    <div class="maintenance-container">
        <div class="maintenance-card">
            <div class="logo">Manu Hosting</div>
            <h1>Wartungsmodus</h1>
            <p><?= htmlspecialchars($message) ?></p>
            <div class="retry-info">Nächster Versuch in ca. <?= gmdate('H:i:s', $retryAfter) ?></div>
        </div>
    </div>
</body>
</html>
        <?php
    }

    private function renderRateLimitPage(int $window): void
    {
        ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zu viele Anfragen - Manu Hosting</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>
    <div class="maintenance-container">
        <div class="maintenance-card">
            <div class="logo">Manu Hosting</div>
            <h1>Zu viele Anfragen</h1>
            <p>Sie haben zu viele Anfragen in kurzer Zeit gestellt. Bitte warten Sie <?= $window ?> Sekunden und versuchen Sie es erneut.</p>
        </div>
    </div>
</body>
</html>
        <?php
    }

    private function renderForbiddenPage(): void
    {
        http_response_code(403);
        ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zugriff verweigert - Manu Hosting</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>
    <div class="maintenance-container">
        <div class="maintenance-card">
            <div class="logo">Manu Hosting</div>
            <h1>Zugriff verweigert</h1>
            <p>Sie haben keine Berechtigung für diesen Bereich.</p>
            <a href="/" class="btn btn-primary">Zur Startseite</a>
        </div>
    </div>
</body>
</html>
        <?php
    }

    private function jsonResponse(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    // Getters
    public function config(): Config { return $this->config; }
    public function db(): Database { return $this->database; }
    public function router(): Router { return $this->router; }
    public function container(): Container { return $this->container; }
    public function events(): Events { return $this->events; }
    public function session(): Session { return $this->session; }
    public function csrf(): Csrf { return $this->csrf; }
    public function rateLimiter(): RateLimiter { return $this->rateLimiter; }
}
