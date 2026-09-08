<?php

declare(strict_types=1);

use App\Application;
use Config\ContainerFactory;

require dirname(__DIR__) . '/vendor/autoload.php';

$container = ContainerFactory::create();

$application = $container->get(Application::class);

$application->run();