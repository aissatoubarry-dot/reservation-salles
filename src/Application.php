<?php

namespace App;

use DI\Container;
use FastRoute\Dispatcher;
use App\Support\ResponseStrategyInterface;

class Application
{
    public function __construct(
        private Dispatcher $dispatcher,
        private Container $container,
        private ResponseStrategyInterface $response
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
                $this->response->notFound();
                break;

            case Dispatcher::METHOD_NOT_ALLOWED:
                $this->response->methodNotAllowed($routeInfo[1]);
                break;

            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $vars = $routeInfo[2];

                //$controller = $this->container->get($handler[0]);
                $controller = $this->container->make($handler[0]);

                $controller->{$handler[1]}(...array_values($vars));
                break;
        }
    }
}