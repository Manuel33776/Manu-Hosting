<?php

namespace App\Helpers;

class Cookie
{
    private string $encryptionKey;
    private array $defaultOptions = [
        'path' => '/',
        'domain' => '',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'lax',
    ];

    public function __construct(string $encryptionKey = '')
    {
        $this->encryptionKey = $encryptionKey ?: hash('sha256', 'manu-hosting-cookie-key-' . ($_SERVER['HTTP_HOST'] ?? 'localhost'));
    }

    public function set(string $name, mixed $value, int $expire = 0, array $options = []): void
    {
        $options = array_merge($this->defaultOptions, $options);
        $value = $this->encrypt(serialize($value));

        setcookie($name, $value, $expire ?: time() + 86400 * 30, $options['path'], $options['domain'], $options['secure'], $options['httponly'], $options['samesite']);
    }

    public function get(string $name, mixed $default = null): mixed
    {
        if (!isset($_COOKIE[$name])) {
            return $default;
        }

        try {
            $value = $this->decrypt($_COOKIE[$name]);
            return unserialize($value);
        } catch (\Throwable $e) {
            return $default;
        }
    }

    public function has(string $name): bool
    {
        return isset($_COOKIE[$name]);
    }

    public function forget(string $name, array $options = []): void
    {
        $options = array_merge($this->defaultOptions, $options);
        setcookie($name, '', time() - 3600, $options['path'], $options['domain'], $options['secure'], $options['httponly'], $options['samesite']);
    }

    public function flush(): void
    {
        foreach ($_COOKIE as $name => $value) {
            $this->forget($name);
        }
    }

    public function forever(string $name, mixed $value, array $options = []): void
    {
        $this->set($name, $value, time() + 86400 * 365 * 10, $options);
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
}
