<?php

return [
    'up' => function (\App\Core\Database $db) {
        $db->execute("
            CREATE TABLE IF NOT EXISTS server_resources (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                server_uuid CHAR(36) NOT NULL,
                cpu_usage DECIMAL(5,2) DEFAULT 0,
                ram_usage BIGINT UNSIGNED DEFAULT 0,
                disk_usage BIGINT UNSIGNED DEFAULT 0,
                network_rx BIGINT UNSIGNED DEFAULT 0,
                network_tx BIGINT UNSIGNED DEFAULT 0,
                recorded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_server_uuid (server_uuid),
                INDEX idx_recorded_at (recorded_at)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    },
    'down' => function (\App\Core\Database $db) {
        $db->execute("DROP TABLE IF EXISTS server_resources");
    }
];
