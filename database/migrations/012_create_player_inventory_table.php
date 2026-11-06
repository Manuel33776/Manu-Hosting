<?php

return [
    'up' => function (\App\Core\Database $db) {
        $db->execute("
            CREATE TABLE IF NOT EXISTS player_inventory (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                server_uuid CHAR(36) NOT NULL,
                player_uuid CHAR(36) NOT NULL,
                player_name VARCHAR(16) NOT NULL,
                inventory_data JSON NOT NULL,
                enderchest_data JSON NULL,
                armor_data JSON NULL,
                offhand_data JSON NULL,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                UNIQUE KEY unique_player_server (server_uuid, player_uuid),
                INDEX idx_server_uuid (server_uuid),
                INDEX idx_player_uuid (player_uuid)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    },
    'down' => function (\App\Core\Database $db) {
        $db->execute("DROP TABLE IF EXISTS player_inventory");
    }
];
