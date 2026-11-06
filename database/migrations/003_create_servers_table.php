<?php

return [
    'up' => function (\App\Core\Database $db) {
        $db->execute("
            CREATE TABLE IF NOT EXISTS servers (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                uuid CHAR(36) NOT NULL UNIQUE,
                user_id BIGINT UNSIGNED NOT NULL,
                node_id BIGINT UNSIGNED NOT NULL,
                package_id BIGINT UNSIGNED NULL,
                name VARCHAR(128) NOT NULL,
                version VARCHAR(32) NOT NULL,
                software VARCHAR(32) NOT NULL,
                java_version VARCHAR(16) NOT NULL,
                ram INT UNSIGNED NOT NULL,
                cpu INT UNSIGNED NOT NULL,
                disk INT UNSIGNED NOT NULL,
                port INT UNSIGNED NULL,
                status ENUM('creating', 'installing', 'online', 'offline', 'starting', 'stopping', 'restarting', 'error', 'suspended', 'idle_shutdown') NOT NULL DEFAULT 'creating',
                players_online INT UNSIGNED DEFAULT 0,
                players_max INT UNSIGNED DEFAULT 20,
                idle_shutdown_enabled TINYINT(1) NOT NULL DEFAULT 1,
                idle_shutdown_timeout INT UNSIGNED NOT NULL DEFAULT 60,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX idx_user_id (user_id),
                INDEX idx_node_id (node_id),
                INDEX idx_uuid (uuid),
                INDEX idx_status (status),
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (node_id) REFERENCES nodes(id) ON DELETE CASCADE,
                FOREIGN KEY (package_id) REFERENCES packages(id) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    },
    'down' => function (\App\Core\Database $db) {
        $db->execute("DROP TABLE IF EXISTS servers");
    }
];
