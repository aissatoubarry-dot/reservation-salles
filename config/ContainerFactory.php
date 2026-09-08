<?php

declare(strict_types=1);

namespace Config;

use DI\Container;
use DI\ContainerBuilder;

final class ContainerFactory
{
    public static function create(): Container
    {
        $builder = new ContainerBuilder();

        $builder->addDefinitions(
            dirname(__DIR__) . '/config/container.php'
        );

        return $builder->build();
    }
}

