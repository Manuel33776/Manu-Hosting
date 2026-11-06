<?php

return [
    'up' => function (\App\Core\Database $db) {
        $db->execute("
            CREATE TABLE IF NOT EXISTS server_commands (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                server_uuid CHAR(36) NOT NULL,
                command VARCHAR(255) NOT NULL,
                status ENUM('pending', 'running', 'completed', 'failed') NOT NULL DEFAULT 'pending',
                result TEXT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                started_at TIMESTAMP NULL,
                completed_at TIMESTAMP NULL,
                INDEX idx_server_uuid (server_uuid),
                INDEX idx_status (status)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    },
    'down' => function (\App\Core\Database $db) {
        $db->execute("DROP TABLE IF EXISTS server_commands");
    }
];
