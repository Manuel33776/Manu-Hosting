<?php

namespace App\Security;

use App\Helpers\Session;

class Csrf
{
    private Session $session;
    private string $tokenName = '_token';
    private int $tokenLength = 32;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function generate(): string
    {
        $token = bin2hex(random_bytes($this->tokenLength));
        $this->session->set($this->tokenName, $token);
        return $token;
    }

    public function getToken(): string
    {
        $token = $this->session->get($this->tokenName);
        if (!$token) {
            $token = $this->generate();
        }
        return $token;
    }

    public function validate(?string $token = null): bool
    {
        $token = $token ?? $_POST[$this->tokenName] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        $storedToken = $this->session->get($this->tokenName);

        if (!$token || !$storedToken) {
            return false;
        }

        // Constant time comparison
        return hash_equals($storedToken, $token);
    }

    public function validateOrFail(?string $token = null): void
    {
        if (!$this->validate($token)) {
            http_response_code(419);
            throw new \RuntimeException('CSRF token validation failed');
        }
    }

    public function input(): string
    {
        return '<input type="hidden" name="' . $this->tokenName . '" value="' . $this->getToken() . '">';
    }

    public function metaTag(): string
    {
        return '<meta name="csrf-token" content="' . $this->getToken() . '">';
    }

    public function setTokenName(string $name): void
    {
        $this->tokenName = $name;
    }

    public function setTokenLength(int $length): void
    {
        $this->tokenLength = max(16, $length);
    }
}
