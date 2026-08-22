<?php

class Router {
    private array $routes = [];

    public function get(string $path, callable $callback): void {
        $this->routes['GET'][$path] = $callback;
    }

    public function post(string $path, callable $callback): void {
        $this->routes['POST'][$path] = $callback;
    }

    public function dispatch(string $method, string $uri): void {
        $uri = strtok($uri, '?');
        foreach ($this->routes[$method] ?? [] as $path => $callback) {
            $pattern = preg_replace('/\{[^}]+\}/', '([^/]+)', $path);
            if (preg_match('#^' . $pattern . '$#', $uri, $matches)) {
                array_shift($matches);
                call_user_func_array($callback, $matches);
                return;
            }
        }
        http_response_code(404);
        echo "404 - Page non trouvée";
    }
}