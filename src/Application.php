<?php

namespace App;

use DI\Container;
use FastRoute\Dispatcher;

class Application
{
    public function __construct(
        private Dispatcher $dispatcher,
        private Container $container
    ) {
    }

    public function run(): void
    {
        $uri = $_SERVER['REQUEST_URI'];

        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        $httpMethod = $_SERVER['REQUEST_METHOD'];

        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {

            case Dispatcher::NOT_FOUND:
                http_response_code(404);
                require dirname(__DIR__) . '/templates/error/404.php';
                break;

            case Dispatcher::METHOD_NOT_ALLOWED:
                http_response_code(405);
                header('Allow: ' . implode(', ', $routeInfo[1]));
                require dirname(__DIR__) . '/templates/error/405.php';
                break;

            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];

                $controller = $this->container->get($handler[0]);

                $controller->{$handler[1]}(...array_values($vars));
                break;
        }
    }
}