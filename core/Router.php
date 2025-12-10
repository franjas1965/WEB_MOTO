<?php

declare(strict_types=1);

namespace Core;

use Controllers\ErrorController;
use InvalidArgumentException;

class Router
{
    /** @var array<string, array<string, array{controller: string, action: string}>> */
    private array $routes;

    public function __construct(array $routes = [])
    {
        $this->routes = $routes;
    }

    public function dispatch(string $uri, string $method = 'GET'): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        $method = strtoupper($method);

        $route = $this->routes[$method][$path] ?? null;

        if ($route === null) {
            $this->handleNotFound();
            return;
        }

        $this->invoke($route['controller'], $route['action']);
    }

    private function invoke(string $controllerClass, string $action): void
    {
        if (!class_exists($controllerClass)) {
            throw new InvalidArgumentException(sprintf('Controller %s not found', $controllerClass));
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $action)) {
            throw new InvalidArgumentException(sprintf('Action %s::%s not found', $controllerClass, $action));
        }

        $controller->$action();
    }

    private void handleNotFound(): void
    {
        $controller = new ErrorController();
        $controller->notFound();
    }
}
