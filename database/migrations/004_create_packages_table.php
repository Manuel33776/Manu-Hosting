<?php

return [
    'up' => function (\App\Core\Database $db) {
        $db->execute("
            CREATE TABLE IF NOT EXISTS packages (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(128) NOT NULL,
                description TEXT NULL,
                ram INT UNSIGNED NOT NULL,
                cpu INT UNSIGNED NOT NULL,
                disk INT UNSIGNED NOT NULL,
                player_slots INT UNSIGNED NOT NULL DEFAULT 20,
                price_monthly DECIMAL(10,2) NOT NULL DEFAULT 0,
                price_quarterly DECIMAL(10,2) NULL,
                price_semi_annual DECIMAL(10,2) NULL,
                price_annual DECIMAL(10,2) NULL,
                features JSON NULL,
                is_active TINYINT(1) NOT NULL DEFAULT 1,
                sort_order INT UNSIGNED NOT NULL DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX idx_active (is_active),
                INDEX idx_sort (sort_order)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    },
    'down' => function (\App\Core\Database $db) {
        $db->execute("DROP TABLE IF EXISTS packages");
    }
];
