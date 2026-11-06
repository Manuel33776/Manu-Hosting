<?php

use App\Core\Database;

return new class {
    public function up(): void
    {
        $db = Database::getInstance();
        
        $db->execute("
            CREATE TABLE IF NOT EXISTS console_tokens (
                id INT AUTO_INCREMENT PRIMARY KEY,
                token VARCHAR(64) NOT NULL UNIQUE,
                server_uuid VARCHAR(36) NOT NULL,
                user_id INT NOT NULL,
                expires_at DATETIME NOT NULL,
                used_at DATETIME NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_token (token),
                INDEX idx_server_uuid (server_uuid),
                INDEX idx_user_id (user_id),
                INDEX idx_expires_at (expires_at)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    }

    public function down(): void
    {
        $db = Database::getInstance();
        $db->execute("DROP TABLE IF EXISTS console_tokens");
    }
};