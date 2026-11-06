<?php

namespace App\Core;

class Config
{
    private array $config = [];

    public function __construct(string $configPath = null)
    {
        $configPath = $configPath ?? __DIR__ . '/../../../config/config.php';
        
        if (!file_exists($configPath)) {
            $configPath = __DIR__ . '/../../../config/config.example.php';
        }

        if (file_exists($configPath)) {
            $this->config = require $configPath;
        }
    }

    public function get(string $key, mixed $default = null): mixed
    {
        $keys = explode('.', $key);
        $value = $this->config;

        foreach ($keys as $k) {
            if (is_array($value) && array_key_exists($k, $value)) {
                $value = $value[$k];
            } else {
                return $default;
            }
        }

        return $value;
    }

    public function set(string $key, mixed $value): void
    {
        $keys = explode('.', $key);
        $target = &$this->config;

        foreach ($keys as $k) {
            if (!isset($target[$k]) || !is_array($target[$k])) {
                $target[$k] = [];
            }
            $target = &$target[$k];
        }

        $target = $value;
    }

    public function has(string $key): bool
    {
        $keys = explode('.', $key);
        $value = $this->config;

        foreach ($keys as $k) {
            if (is_array($value) && array_key_exists($k, $value)) {
                $value = $value[$k];
            } else {
                return false;
            }
        }

        return true;
    }

    public function all(): array
    {
        return $this->config;
    }
}
