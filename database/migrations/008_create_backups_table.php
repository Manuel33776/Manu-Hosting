<?php

return [
    'up' => function (\App\Core\Database $db) {
        $db->execute("
            CREATE TABLE IF NOT EXISTS backups (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                uuid CHAR(36) NOT NULL UNIQUE,
                server_id BIGINT UNSIGNED NOT NULL,
                type ENUM('manual', 'scheduled', 'auto') NOT NULL DEFAULT 'manual',
                status ENUM('pending', 'running', 'completed', 'failed') NOT NULL DEFAULT 'pending',
                file_path VARCHAR(512) NULL,
                file_size BIGINT UNSIGNED NULL,
                compression VARCHAR(16) NULL,
                started_at TIMESTAMP NULL,
                completed_at TIMESTAMP NULL,
                error_message TEXT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_server_id (server_id),
                INDEX idx_uuid (uuid),
                INDEX idx_status (status),
                FOREIGN KEY (server_id) REFERENCES servers(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    },
    'down' => function (\App\Core\Database $db) {
        $db->execute("DROP TABLE IF EXISTS backups");
    }
];
