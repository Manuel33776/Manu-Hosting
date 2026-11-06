<?php

return [
    'up' => function (\App\Core\Database $db) {
        $db->execute("
            CREATE TABLE IF NOT EXISTS orders (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                order_number VARCHAR(32) NOT NULL UNIQUE,
                user_id BIGINT UNSIGNED NOT NULL,
                package_id BIGINT UNSIGNED NOT NULL,
                status ENUM('pending', 'processing', 'completed', 'cancelled', 'failed', 'refunded') NOT NULL DEFAULT 'pending',
                billing_cycle ENUM('monthly', 'quarterly', 'semi_annual', 'annual') NOT NULL DEFAULT 'monthly',
                amount DECIMAL(10,2) NOT NULL,
                currency CHAR(3) NOT NULL DEFAULT 'EUR',
                payment_method VARCHAR(64) NULL,
                payment_id VARCHAR(128) NULL,
                paid_at TIMESTAMP NULL,
                expires_at TIMESTAMP NULL,
                cancelled_at TIMESTAMP NULL,
                notes TEXT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                INDEX idx_user_id (user_id),
                INDEX idx_package_id (package_id),
                INDEX idx_status (status),
                INDEX idx_order_number (order_number),
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (package_id) REFERENCES packages(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    },
    'down' => function (\App\Core\Database $db) {
        $db->execute("DROP TABLE IF EXISTS orders");
    }
];
