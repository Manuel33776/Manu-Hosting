<?php

namespace App\Core;

class Events
{
    private array $listeners = [];
    private array $wildcardListeners = [];

    public function listen(string $event, callable $listener): void
    {
        if (str_ends_with($event, '.*')) {
            $this->wildcardListeners[$event][] = $listener;
        } else {
            $this->listeners[$event][] = $listener;
        }
    }

    public function listenOnce(string $event, callable $listener): void
    {
        $wrappedListener = function (...$args) use ($event, $listener) {
            $listener(...$args);
            $this->forget($event, $wrappedListener);
        };
        $this->listen($event, $wrappedListener);
    }

    public function dispatch(string $event, array $payload = []): array
    {
        $responses = [];

        // Direct listeners
        if (isset($this->listeners[$event])) {
            foreach ($this->listeners[$event] as $listener) {
                $responses[] = $listener($payload);
            }
        }

        // Wildcard listeners
        foreach ($this->wildcardListeners as $pattern => $listeners) {
            $regex = str_replace('\*', '.*', preg_quote($pattern, '/'));
            $regex = '#^' . $regex . '$#';

            if (preg_match($regex, $event)) {
                foreach ($listeners as $listener) {
                    $responses[] = $listener($payload);
                }
            }
        }

        return $responses;
    }

    public function dispatchUntil(string $event, array $payload = []): mixed
    {
        // Direct listeners
        if (isset($this->listeners[$event])) {
            foreach ($this->listeners[$event] as $listener) {
                $response = $listener($payload);
                if ($response !== null) {
                    return $response;
                }
            }
        }

        // Wildcard listeners
        foreach ($this->wildcardListeners as $pattern => $listeners) {
            $regex = str_replace('\*', '.*', preg_quote($pattern, '/'));
            $regex = '#^' . $regex . '$#';

            if (preg_match($regex, $event)) {
                foreach ($listeners as $listener) {
                    $response = $listener($payload);
                    if ($response !== null) {
                        return $response;
                    }
                }
            }
        }

        return null;
    }

    public function forget(string $event, callable $listener = null): void
    {
        if ($listener === null) {
            unset($this->listeners[$event], $this->wildcardListeners[$event]);
        } else {
            if (isset($this->listeners[$event])) {
                $key = array_search($listener, $this->listeners[$event], true);
                if ($key !== false) {
                    unset($this->listeners[$event][$key]);
                }
            }
            if (isset($this->wildcardListeners[$event])) {
                $key = array_search($listener, $this->wildcardListeners[$event], true);
                if ($key !== false) {
                    unset($this->wildcardListeners[$event][$key]);
                }
            }
        }
    }

    public function getListeners(string $event): array
    {
        return $this->listeners[$event] ?? [];
    }

    public function hasListeners(string $event): bool
    {
        return !empty($this->listeners[$event]) || !empty($this->wildcardListeners[$event]);
    }
}
