<?php

return [
    'up' => function (\App\Core\Database $db) {
        $db->execute("
            CREATE TABLE IF NOT EXISTS platform_status (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                type ENUM('maintenance', 'wip', 'servers_offline') NOT NULL,
                enabled TINYINT(1) NOT NULL DEFAULT 0,
                message TEXT NULL,
                started_at TIMESTAMP NULL,
                planned_end_at TIMESTAMP NULL,
                ended_at TIMESTAMP NULL,
                created_by BIGINT UNSIGNED NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX idx_type (type),
                INDEX idx_enabled (enabled),
                FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    },
    'down' => function (\App\Core\Database $db) {
        $db->execute("DROP TABLE IF EXISTS platform_status");
    }
];
