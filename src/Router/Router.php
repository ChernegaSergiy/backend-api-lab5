<?php

namespace App\Router;

class Router
{
    private array $routes = [];

    public function get(string $uri, array $action): void
    {
        $this->routes['GET'][$uri] = $action;
    }

    public function dispatch(string $method, string $uri): void
    {
        $uri = strtok($uri, '?');

        foreach ($this->routes[$method] as $route => $action) {
            $route_pattern = preg_replace('/\{([a-zA-Z]+)\}/', '(?P<$1>[a-zA-Z0-9_-]+)', $route);
            $route_pattern = '#^' . $route_pattern . '$#';

            if (preg_match($route_pattern, $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                [$class, $method] = $action;

                if (class_exists($class)) {
                    $controller = new $class();
                    if (method_exists($controller, $method)) {
                        call_user_func_array([$controller, $method], $params);
                        return;
                    }
                }
            }
        }

        $this->notFound();
    }

    private function notFound(): void
    {
        http_response_code(404);
        echo json_encode(['message' => 'Not Found']);
    }
}

