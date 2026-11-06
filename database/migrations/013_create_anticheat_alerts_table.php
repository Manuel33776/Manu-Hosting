<?php

return [
    'up' => function (\App\Core\Database $db) {
        $db->execute("
            CREATE TABLE IF NOT EXISTS anticheat_alerts (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                server_uuid CHAR(36) NOT NULL,
                player_uuid CHAR(36) NOT NULL,
                player_name VARCHAR(16) NOT NULL,
                rule VARCHAR(128) NOT NULL,
                severity ENUM('suspicious', 'violation', 'critical') NOT NULL DEFAULT 'suspicious',
                details JSON NULL,
                evidence JSON NULL,
                acknowledged TINYINT(1) NOT NULL DEFAULT 0,
                acknowledged_by BIGINT UNSIGNED NULL,
                acknowledged_at TIMESTAMP NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_server_uuid (server_uuid),
                INDEX idx_player_uuid (player_uuid),
                INDEX idx_severity (severity),
                INDEX idx_acknowledged (acknowledged),
                INDEX idx_created_at (created_at)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    },
    'down' => function (\App\Core\Database $db) {
        $db->execute("DROP TABLE IF EXISTS anticheat_alerts");
    }
];
