<?php

namespace App\Security;

use App\Core\Database;

class RateLimiter
{
    private Database $db;
    private array $defaultLimits;
    private string $table = 'rate_limits';

    public function __construct(Database $db, array $defaultLimits = [])
    {
        $this->db = $db;
        $this->defaultLimits = $defaultLimits;
        $this->ensureTableExists();
    }

    private function ensureTableExists(): void
    {
        if (!$this->db->tableExists($this->table)) {
            $this->db->execute("
                CREATE TABLE {$this->table} (
                    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    `key` VARCHAR(255) NOT NULL,
                    hits INT UNSIGNED NOT NULL DEFAULT 0,
                    window_start INT UNSIGNED NOT NULL,
                    window_size INT UNSIGNED NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    UNIQUE KEY unique_key_window (`key`, window_start, window_size)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
        }
    }

    public function check(string $key, int $maxRequests, int $windowSeconds): bool
    {
        $now = time();
        $windowStart = $now - ($now % $windowSeconds);

        // Clean old entries periodically
        if (mt_rand(1, 100) === 1) {
            $this->cleanup($now);
        }

        // Try to insert or update
        try {
            $this->db->execute(
                "INSERT INTO {$this->table} (`key`, hits, window_start, window_size) 
                 VALUES (?, 1, ?, ?)
                 ON DUPLICATE KEY UPDATE hits = hits + 1",
                [$key, $windowStart, $windowSeconds]
            );
        } catch (\Throwable $e) {
            // If insert fails due to race condition, try update
            $this->db->execute(
                "UPDATE {$this->table} SET hits = hits + 1 WHERE `key` = ? AND window_start = ? AND window_size = ?",
                [$key, $windowStart, $windowSeconds]
            );
        }

        // Get current count
        $result = $this->db->queryOne(
            "SELECT hits FROM {$this->table} WHERE `key` = ? AND window_start = ? AND window_size = ?",
            [$key, $windowStart, $windowSeconds]
        );

        $hits = $result['hits'] ?? 0;
        return $hits <= $maxRequests;
    }

    public function getRemaining(string $key, int $maxRequests, int $windowSeconds): int
    {
        $now = time();
        $windowStart = $now - ($now % $windowSeconds);

        $result = $this->db->queryOne(
            "SELECT hits FROM {$this->table} WHERE `key` = ? AND window_start = ? AND window_size = ?",
            [$key, $windowStart, $windowSeconds]
        );

        $hits = $result['hits'] ?? 0;
        return max(0, $maxRequests - $hits);
    }

    public function getRetryAfter(string $key, int $windowSeconds): int
    {
        $now = time();
        $windowStart = $now - ($now % $windowSeconds);
        return $windowStart + $windowSeconds - $now;
    }

    public function reset(string $key): void
    {
        $this->db->execute("DELETE FROM {$this->table} WHERE `key` = ?", [$key]);
    }

    public function resetAll(): void
    {
        $this->db->execute("TRUNCATE TABLE {$this->table}");
    }

    private function cleanup(int $now): void
    {
        $this->db->execute(
            "DELETE FROM {$this->table} WHERE window_start + window_size < ?",
            [$now]
        );
    }

    // Sliding window algorithm (more accurate)
    public function checkSliding(string $key, int $maxRequests, int $windowSeconds): bool
    {
        $now = time();
        $windowStart = $now - $windowSeconds;

        // Use a sliding log approach with separate table
        $table = $this->table . '_sliding';

        if (!$this->db->tableExists($table)) {
            $this->db->execute("
                CREATE TABLE {$table} (
                    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    `key` VARCHAR(255) NOT NULL,
                    request_time INT UNSIGNED NOT NULL,
                    INDEX idx_key_time (`key`, request_time)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
        }

        // Remove old entries
        $this->db->execute("DELETE FROM {$table} WHERE `key` = ? AND request_time < ?", [$key, $windowStart]);

        // Count current requests
        $result = $this->db->queryOne("SELECT COUNT(*) as count FROM {$table} WHERE `key` = ?", [$key]);
        $count = $result['count'] ?? 0;

        if ($count < $maxRequests) {
            $this->db->execute("INSERT INTO {$table} (`key`, request_time) VALUES (?, ?)", [$key, $now]);
            return true;
        }

        return false;
    }
}
