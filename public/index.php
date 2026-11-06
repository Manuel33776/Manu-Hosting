<?php

/**
 * Manu Hosting - Entry Point
 * 
 * Professional Minecraft Hosting Platform
 * 
 * @package ManuHosting
 * @version 1.0.0
 */

// Define base path
define('BASE_PATH', __DIR__ . '/..');

// Load Composer autoloader if exists
if (file_exists(BASE_PATH . '/vendor/autoload.php')) {
    require_once BASE_PATH . '/vendor/autoload.php';
} else {
    // Simple PSR-4 autoloader for development
    spl_autoload_register(function ($class) {
        $prefix = 'App\\';
        $baseDir = BASE_PATH . '/app/';
        
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {
            return;
        }
        
        $relativeClass = substr($class, $len);
        $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
        
        if (file_exists($file)) {
            require_once $file;
        }
    });
}

// Load configuration
$configPath = BASE_PATH . '/config/config.php';
if (!file_exists($configPath)) {
    $configPath = BASE_PATH . '/config/config.example.php';
}

// Error handling
if ((require $configPath)['app']['debug'] ?? false) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING & ~E_DEPRECATED);
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
    ini_set('error_log', BASE_PATH . '/storage/logs/php_errors.log');
}

// Set default timezone
date_default_timezone_set('Europe/Berlin');

// Start session early for CSRF and auth
session_start();

// Bootstrap application
try {
    $app = \App\Core\Application::getInstance();
    $app->run();
} catch (\Throwable $e) {
    // Log error
    error_log('Application error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
    
    if (($configPath && (require $configPath)['app']['debug'] ?? false)) {
        // Show detailed error in debug mode
        http_response_code(500);
        ?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serverfehler - Manu Hosting</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>
    <div class="error-container">
        <div class="error-card">
            <h1>Serverfehler</h1>
            <p>Ein unerwarteter Fehler ist aufgetreten.</p>
            <pre><?= htmlspecialchars($e->getMessage()) ?></pre>
            <p><small>Datei: <?= htmlspecialchars($e->getFile()) ?> Zeile: <?= $e->getLine() ?></small></p>
            <a href="/" class="btn btn-primary">Zur Startseite</a>
        </div>
    </div>
</body>
</html>
        <?php
    } else {
        // Generic error page
        http_response_code(500);
        include BASE_PATH . '/public/pages/public/500.php';
    }
}
