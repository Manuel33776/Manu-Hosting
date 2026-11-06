<?php

return [
    'up' => function (\App\Core\Database $db) {
        $db->execute("
            CREATE TABLE IF NOT EXISTS nodes (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(128) NOT NULL,
                host VARCHAR(255) NOT NULL,
                api_port INT UNSIGNED NOT NULL DEFAULT 8443,
                token VARCHAR(255) NOT NULL UNIQUE,
                status ENUM('online', 'offline', 'maintenance') NOT NULL DEFAULT 'offline',
                cpu_cores INT UNSIGNED NULL,
                cpu_usage DECIMAL(5,2) DEFAULT 0,
                ram_total BIGINT UNSIGNED NULL,
                ram_used BIGINT UNSIGNED DEFAULT 0,
                disk_total BIGINT UNSIGNED NULL,
                disk_used BIGINT UNSIGNED DEFAULT 0,
                network_rx BIGINT UNSIGNED DEFAULT 0,
                network_tx BIGINT UNSIGNED DEFAULT 0,
                servers_online INT UNSIGNED DEFAULT 0,
                servers_total INT UNSIGNED DEFAULT 0,
                last_heartbeat TIMESTAMP NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX idx_token (token),
                INDEX idx_status (status)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    },
    'down' => function (\App\Core\Database $db) {
        $db->execute("DROP TABLE IF EXISTS nodes");
    }
];
