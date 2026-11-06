<?php

return [
    'up' => function (\App\Core\Database $db) {
        $db->execute("
            CREATE TABLE IF NOT EXISTS sessions (
                id VARCHAR(128) PRIMARY KEY,
                user_id BIGINT UNSIGNED NULL,
                ip_address VARCHAR(45) NOT NULL,
                user_agent TEXT NULL,
                payload LONGTEXT NOT NULL,
                last_activity INT UNSIGNED NOT NULL,
                expires_at INT UNSIGNED NOT NULL,
                INDEX idx_user_id (user_id),
                INDEX idx_expires (expires_at),
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    },
    'down' => function (\App\Core\Database $db) {
        $db->execute("DROP TABLE IF EXISTS sessions");
    }
];
