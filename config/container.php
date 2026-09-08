<?php

declare(strict_types=1);

use App\Application;
use App\Controller\ReservationController;
use App\Controller\SalleController;
use App\Repository\ReservationRepository;
use App\Repository\SalleRepository;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Service\AnnulerReservationService;
use App\Service\CreerReservationService;
use App\Validation\ReservationValidator;
use App\Validation\SalleValidator;
use Dotenv\Dotenv;
use FastRoute\Dispatcher;
use Illuminate\Database\Capsule\Manager;
use function DI\autowire;
use function DI\factory;
use function FastRoute\simpleDispatcher;

return [

    Manager::class => factory(function (): Manager {

        $dotenv = Dotenv::createImmutable(
            dirname(__DIR__)
        );

        $dotenv->load();

        $capsule = new Manager();

        $capsule->addConnection([
            'driver' => $_ENV['DB_DRIVER'],
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'database' => $_ENV['DB_DATABASE'],
            'username' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
        ]);

        $capsule->setAsGlobal();

        $capsule->bootEloquent();

        return $capsule;
    }),



    SalleRepositoryInterface::class =>
        autowire(SalleRepository::class),

    ReservationRepositoryInterface::class =>
        autowire(ReservationRepository::class),



    SalleValidator::class =>
        autowire(SalleValidator::class),

    ReservationValidator::class =>
        autowire(ReservationValidator::class),


   

    CreerReservationService::class =>
        autowire(CreerReservationService::class),

    AnnulerReservationService::class =>
        autowire(AnnulerReservationService::class),



    SalleController::class =>
        autowire(SalleController::class),

    ReservationController::class =>
        autowire(ReservationController::class),



    Dispatcher::class => factory(function (): Dispatcher {

        return simpleDispatcher(
            function ($router): void {

                $routes = require dirname(__DIR__)
                    . '/routes/web.php';

                $routes($router);
            }
        );
    }),



    Application::class =>
        autowire(Application::class),
];