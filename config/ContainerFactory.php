<?php

declare(strict_types=1);

namespace Config;

use DI\Container;
use DI\ContainerBuilder;
use Illuminate\Database\Capsule\Manager;

final class ContainerFactory
{
    public static function create(): Container
    {
        $builder = new ContainerBuilder();

        $builder->addDefinitions(
            dirname(__DIR__) . '/config/container.php'
        );

        $container = $builder->build();

        $container->get(Manager::class);

        return $container;
    }
}

