<?php

namespace App\Core;

class Container
{
    private array $bindings = [];
    private array $instances = [];
    private array $resolving = [];

    public function bind(string $abstract, callable $concrete, bool $shared = false): void
    {
        $this->bindings[$abstract] = [
            'concrete' => $concrete,
            'shared' => $shared,
        ];
    }

    public function singleton(string $abstract, callable $concrete): void
    {
        $this->bind($abstract, $concrete, true);
    }

    public function instance(string $abstract, object $instance): void
    {
        $this->instances[$abstract] = $instance;
    }

    public function make(string $abstract, array $parameters = []): mixed
    {
        // Return existing instance if singleton
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }

        // Check for circular dependencies
        if (isset($this->resolving[$abstract])) {
            throw new \RuntimeException("Circular dependency detected for {$abstract}");
        }

        // Get binding
        if (!isset($this->bindings[$abstract])) {
            // Try to auto-resolve class
            if (class_exists($abstract)) {
                return $this->resolveClass($abstract, $parameters);
            }
            throw new \InvalidArgumentException("No binding found for {$abstract}");
        }

        $binding = $this->bindings[$abstract];
        $this->resolving[$abstract] = true;

        try {
            $instance = $binding['concrete']($this, $parameters);

            if ($binding['shared']) {
                $this->instances[$abstract] = $instance;
            }

            return $instance;
        } finally {
            unset($this->resolving[$abstract]);
        }
    }

    private function resolveClass(string $class, array $parameters = []): object
    {
        $reflection = new \ReflectionClass($class);

        if (!$reflection->isInstantiable()) {
            throw new \RuntimeException("Class {$class} is not instantiable");
        }

        $constructor = $reflection->getConstructor();

        if ($constructor === null) {
            return new $class();
        }

        $dependencies = [];

        foreach ($constructor->getParameters() as $parameter) {
            $name = $parameter->getName();
            $type = $parameter->getType();

            // Check if provided in parameters
            if (array_key_exists($name, $parameters)) {
                $dependencies[] = $parameters[$name];
                continue;
            }

            // Try to resolve from container
            if ($type !== null && !$type->isBuiltin()) {
                $typeName = $type->getName();
                if ($this->has($typeName) || class_exists($typeName)) {
                    $dependencies[] = $this->make($typeName);
                    continue;
                }
            }

            // Use default value if available
            if ($parameter->isDefaultValueAvailable()) {
                $dependencies[] = $parameter->getDefaultValue();
                continue;
            }

            throw new \RuntimeException("Cannot resolve parameter {$name} for {$class}");
        }

        return $reflection->newInstanceArgs($dependencies);
    }

    public function has(string $abstract): bool
    {
        return isset($this->bindings[$abstract]) || isset($this->instances[$abstract]);
    }

    public function forget(string $abstract): void
    {
        unset($this->bindings[$abstract], $this->instances[$abstract]);
    }

    public function call(callable $callback, array $parameters = []): mixed
    {
        $reflection = new \ReflectionFunction($callback);
        $dependencies = [];

        foreach ($reflection->getParameters() as $parameter) {
            $name = $parameter->getName();
            $type = $parameter->getType();

            if (array_key_exists($name, $parameters)) {
                $dependencies[] = $parameters[$name];
                continue;
            }

            if ($type !== null && !$type->isBuiltin()) {
                $typeName = $type->getName();
                if ($this->has($typeName) || class_exists($typeName)) {
                    $dependencies[] = $this->make($typeName);
                    continue;
                }
            }

            if ($parameter->isDefaultValueAvailable()) {
                $dependencies[] = $parameter->getDefaultValue();
                continue;
            }

            throw new \RuntimeException("Cannot resolve parameter {$name} for callable");
        }

        return $reflection->invokeArgs($dependencies);
    }
}
