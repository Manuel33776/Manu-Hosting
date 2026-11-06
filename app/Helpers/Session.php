<?php

namespace App\Helpers;

use App\Core\Database;
use RuntimeException;

class Session
{
    private Database $db;
    private array $config;
    private string $table = 'sessions';
    private ?string $sessionId = null;
    private array $data = [];
    private bool $started = false;
    private bool $encrypted = false;
    private string $encryptionKey = '';

    public function __construct(Database $db, array $config = [])
    {
        $this->db = $db;
        $this->config = array_merge([
            'lifetime' => 7200,
            'encrypt' => true,
            'cookie' => 'manu_session',
            'path' => '/',
            'domain' => '',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'lax',
        ], $config);

        $this->encryptionKey = $this->generateEncryptionKey();
        $this->ensureTableExists();
    }

    private function generateEncryptionKey(): string
    {
        // In production, this should come from config
        return hash('sha256', 'manu-hosting-session-key-' . ($_SERVER['HTTP_HOST'] ?? 'localhost'));
    }

    private function ensureTableExists(): void
    {
        if (!$this->db->tableExists($this->table)) {
            $this->db->execute("
                CREATE TABLE {$this->table} (
                    id VARCHAR(128) PRIMARY KEY,
                    user_id BIGINT UNSIGNED NULL,
                    ip_address VARCHAR(45) NOT NULL,
                    user_agent TEXT,
                    payload LONGTEXT NOT NULL,
                    last_activity INT UNSIGNED NOT NULL,
                    expires_at INT UNSIGNED NOT NULL,
                    INDEX idx_user_id (user_id),
                    INDEX idx_expires (expires_at)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            ");
        }
    }

    public function start(): bool
    {
        if ($this->started) {
            return true;
        }

        // Get session ID from cookie
        $cookieName = $this->config['cookie'];
        $this->sessionId = $_COOKIE[$cookieName] ?? null;

        if ($this->sessionId) {
            $this->loadSession($this->sessionId);
        }

        // Generate new session if not loaded or expired
        if (!$this->sessionId || !$this->data) {
            $this->regenerate();
        }

        // Set cookie
        $this->setCookie();

        // Update last activity
        $this->updateActivity();

        $this->started = true;
        return true;
    }

    private function loadSession(string $id): void
    {
        $result = $this->db->queryOne(
            "SELECT payload, expires_at FROM {$this->table} WHERE id = ? AND expires_at > ?",
            [$id, time()]
        );

        if ($result) {
            $payload = $result['payload'];
            
            if ($this->config['encrypt']) {
                $payload = $this->decrypt($payload);
            }

            $this->data = json_decode($payload, true) ?? [];
        }
    }

    private function saveSession(): void
    {
        if (!$this->sessionId) {
            return;
        }

        $payload = json_encode($this->data);
        
        if ($this->config['encrypt']) {
            $payload = $this->encrypt($payload);
        }

        $expiresAt = time() + $this->config['lifetime'];

        $this->db->execute(
            "INSERT INTO {$this->table} (id, user_id, ip_address, user_agent, payload, last_activity, expires_at)
             VALUES (?, ?, ?, ?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE
                 user_id = VALUES(user_id),
                 ip_address = VALUES(ip_address),
                 user_agent = VALUES(user_agent),
                 payload = VALUES(payload),
                 last_activity = VALUES(last_activity),
                 expires_at = VALUES(expires_at)",
            [
                $this->sessionId,
                $this->data['user_id'] ?? null,
                $_SERVER['REMOTE_ADDR'] ?? '',
                $_SERVER['HTTP_USER_AGENT'] ?? '',
                $payload,
                time(),
                $expiresAt,
            ]
        );
    }

    private function updateActivity(): void
    {
        if ($this->sessionId) {
            $this->db->execute(
                "UPDATE {$this->table} SET last_activity = ? WHERE id = ?",
                [time(), $this->sessionId]
            );
        }
    }

    public function regenerate(bool $destroy = false): string
    {
        if ($destroy && $this->sessionId) {
            $this->destroy();
        }

        $this->sessionId = bin2hex(random_bytes(32));
        $this->data = [];
        $this->setCookie();
        $this->saveSession();

        return $this->sessionId;
    }

    public function destroy(): void
    {
        if ($this->sessionId) {
            $this->db->execute("DELETE FROM {$this->table} WHERE id = ?", [$this->sessionId]);
            $this->sessionId = null;
            $this->data = [];
            
            // Delete cookie
            setcookie(
                $this->config['cookie'],
                '',
                time() - 3600,
                $this->config['path'],
                $this->config['domain'],
                $this->config['secure'],
                $this->config['httponly'],
                $this->config['samesite']
            );
        }
    }

    public function set(string $key, mixed $value): void
    {
        $keys = explode('.', $key);
        $target = &$this->data;

        foreach ($keys as $k) {
            if (!isset($target[$k]) || !is_array($target[$k])) {
                $target[$k] = [];
            }
            $target = &$target[$k];
        }

        $target = $value;
        $this->saveSession();
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $keys = explode('.', $key);
        $value = $this->data;

        foreach ($keys as $k) {
            if (is_array($value) && array_key_exists($k, $value)) {
                $value = $value[$k];
            } else {
                return $default;
            }
        }

        return $value;
    }

    public function has(string $key): bool
    {
        $keys = explode('.', $key);
        $value = $this->data;

        foreach ($keys as $k) {
            if (is_array($value) && array_key_exists($k, $value)) {
                $value = $value[$k];
            } else {
                return false;
            }
        }

        return true;
    }

    public function forget(string $key): void
    {
        $keys = explode('.', $key);
        $target = &$this->data;

        foreach ($keys as $k) {
            if (!isset($target[$k])) {
                return;
            }
            if (count($keys) === 1) {
                unset($target[$k]);
            } else {
                $target = &$target[$k];
            }
        }
        $this->saveSession();
    }

    public function all(): array
    {
        return $this->data;
    }

    public function flush(): void
    {
        $this->data = [];
        $this->saveSession();
    }

    public function getId(): ?string
    {
        return $this->sessionId;
    }

    private function setCookie(): void
    {
        if (!$this->sessionId) {
            return;
        }

        setcookie(
            $this->config['cookie'],
            $this->sessionId,
            time() + $this->config['lifetime'],
            $this->config['path'],
            $this->config['domain'],
            $this->config['secure'],
            $this->config['httponly'],
            $this->config['samesite']
        );
    }

    private function encrypt(string $data): string
    {
        $iv = random_bytes(16);
        $encrypted = openssl_encrypt($data, 'AES-256-CBC', $this->encryptionKey, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $encrypted);
    }

    private function decrypt(string $data): string
    {
        $data = base64_decode($data);
        $iv = substr($data, 0, 16);
        $encrypted = substr($data, 16);
        return openssl_decrypt($encrypted, 'AES-256-CBC', $this->encryptionKey, OPENSSL_RAW_DATA, $iv);
    }

    public function cleanup(): int
    {
        $result = $this->db->execute(
            "DELETE FROM {$this->table} WHERE expires_at < ?",
            [time()]
        );
        return $result;
    }
}
