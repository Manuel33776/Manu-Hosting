<?php

return [
    'up' => function (\App\Core\Database $db) {
        $db->execute("
            CREATE TABLE IF NOT EXISTS tickets (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                ticket_number VARCHAR(32) NOT NULL UNIQUE,
                user_id BIGINT UNSIGNED NOT NULL,
                assigned_to BIGINT UNSIGNED NULL,
                subject VARCHAR(255) NOT NULL,
                status ENUM('open', 'in_progress', 'waiting_customer', 'waiting_support', 'closed') NOT NULL DEFAULT 'open',
                priority ENUM('low', 'normal', 'high', 'urgent') NOT NULL DEFAULT 'normal',
                category VARCHAR(64) NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                closed_at TIMESTAMP NULL,
                INDEX idx_user_id (user_id),
                INDEX idx_assigned_to (assigned_to),
                INDEX idx_status (status),
                INDEX idx_priority (priority),
                INDEX idx_ticket_number (ticket_number),
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    },
    'down' => function (\App\Core\Database $db) {
        $db->execute("DROP TABLE IF EXISTS tickets");
    }
];
