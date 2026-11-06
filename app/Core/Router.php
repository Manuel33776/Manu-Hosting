<?php

namespace App\Core;

class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [],
        'PATCH' => [],
        'DELETE' => [],
        'ANY' => [],
    ];
    private array $middlewares = [];
    private Container $container;
    private ?array $currentRoute = null;
    private array $routeParams = [];

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function get(string $path, $handler, array $options = []): self
    {
        return $this->addRoute('GET', $path, $handler, $options);
    }

    public function post(string $path, $handler, array $options = []): self
    {
        return $this->addRoute('POST', $path, $handler, $options);
    }

    public function put(string $path, $handler, array $options = []): self
    {
        return $this->addRoute('PUT', $path, $handler, $options);
    }

    public function patch(string $path, $handler, array $options = []): self
    {
        return $this->addRoute('PATCH', $path, $handler, $options);
    }

    public function delete(string $path, $handler, array $options = []): self
    {
        return $this->addRoute('DELETE', $path, $handler, $options);
    }

    public function any(string $path, $handler, array $options = []): self
    {
        return $this->addRoute('ANY', $path, $handler, $options);
    }

    public function group(string $prefix, callable $callback, array $options = []): self
    {
        $previousPrefix = $this->getCurrentPrefix();
        $this->setCurrentPrefix($prefix);
        
        $callback($this);
        
        $this->setCurrentPrefix($previousPrefix);
        return $this;
    }

    private string $currentPrefix = '';

    private function getCurrentPrefix(): string
    {
        return $this->currentPrefix;
    }

    private function setCurrentPrefix(string $prefix): void
    {
        $this->currentPrefix = $prefix;
    }

    private function addRoute(string $method, string $path, $handler, array $options): self
    {
        $fullPath = $this->currentPrefix . $path;
        $route = array_merge([
            'path' => $fullPath,
            'handler' => $handler,
            'middleware' => [],
            'auth' => false,
            'roles' => [],
            'name' => null,
        ], $options);

        $this->routes[$method][$fullPath] = $route;
        
        if ($method !== 'ANY') {
            $this->routes['ANY'][$fullPath] = $route;
        }

        return $this;
    }

    public function middleware(callable $middleware): self
    {
        $this->middlewares[] = $middleware;
        return $this;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = rtrim($uri, '/') ?: '/';

        // Find matching route
        $route = $this->matchRoute($method, $uri);
        
        if (!$route) {
            // Try ANY method
            $route = $this->matchRoute('ANY', $uri);
        }

        if (!$route) {
            $this->handle404();
            return;
        }

        $this->currentRoute = $route;
        $this->routeParams = $route['params'] ?? [];

        // Execute middlewares then handler
        $handler = $route['handler'];
        $middlewareChain = array_merge($this->middlewares, $route['middleware'] ?? []);
        
        $response = $this->executeMiddlewareChain($middlewareChain, function () use ($handler) {
            return $this->executeHandler($handler);
        });

        if ($response !== null) {
            $this->sendResponse($response);
        }
    }

    private function matchRoute(string $method, string $uri): ?array
    {
        $routes = $this->routes[$method] ?? [];

        foreach ($routes as $path => $route) {
            $params = [];
            
            // Convert route pattern to regex
            $pattern = preg_replace('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', '(?P<$1>[^/]+)', $path);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                // Extract named parameters
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $params[$key] = $value;
                    }
                }
                
                $route['params'] = $params;
                return $route;
            }
        }

        return null;
    }

    private function executeMiddlewareChain(array $middlewares, callable $next): mixed
    {
        $middleware = array_shift($middlewares);
        
        if (!$middleware) {
            return $next();
        }

        $request = [
            'uri' => $_SERVER['REQUEST_URI'],
            'method' => $_SERVER['REQUEST_METHOD'],
            'params' => $this->routeParams,
            'input' => $this->getInput(),
        ];

        return $middleware($request, function () use ($middlewares, $next) {
            return $this->executeMiddlewareChain($middlewares, $next);
        });
    }

    private function executeHandler($handler): mixed
    {
        if (is_callable($handler)) {
            return $handler($this->routeParams);
        }

        if (is_string($handler) && str_contains($handler, '@')) {
            [$controllerClass, $method] = explode('@', $handler);
            $controller = $this->container->make($controllerClass);
            return $controller->$method($this->routeParams);
        }

        if (is_array($handler) && count($handler) === 2) {
            [$controller, $method] = $handler;
            if (is_string($controller)) {
                $controller = $this->container->make($controller);
            }
            return $controller->$method($this->routeParams);
        }

        throw new \InvalidArgumentException('Invalid route handler');
    }

    private function getInput(): array
    {
        $input = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $input = $_GET;
        } else {
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
            
            if (str_starts_with($contentType, 'application/json')) {
                $input = json_decode(file_get_contents('php://input'), true) ?? [];
            } elseif (str_starts_with($contentType, 'application/x-www-form-urlencoded')) {
                $input = $_POST;
            } elseif (str_starts_with($contentType, 'multipart/form-data')) {
                $input = array_merge($_POST, $_FILES);
            }
        }

        return $input;
    }

    private function sendResponse(mixed $response): void
    {
        if ($response instanceof \App\Core\Response) {
            $response->send();
        } elseif (is_string($response)) {
            echo $response;
        } elseif (is_array($response) || is_object($response)) {
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }

    private function handle404(): void
    {
        http_response_code(404);
        
        if (str_starts_with($_SERVER['REQUEST_URI'], '/api/')) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Not found']);
        } else {
            include __DIR__ . '/../../public/pages/public/404.php';
        }
        exit;
    }

    public function getCurrentRoute(): ?array
    {
        return $this->currentRoute;
    }

    public function getRouteParams(): array
    {
        return $this->routeParams;
    }

    public function url(string $name, array $params = []): string
    {
        // Simple named route URL generation
        foreach ($this->routes as $methodRoutes) {
            foreach ($methodRoutes as $path => $route) {
                if (($route['name'] ?? null) === $name) {
                    $url = $path;
                    foreach ($params as $key => $value) {
                        $url = str_replace("{{$key}}", $value, $url);
                    }
                    return $url;
                }
            }
        }
        return '/';
    }
}
