<?php

use DI\ContainerBuilder;
use App\Repository\SalleRepositoryInterface;
use App\Repository\SalleRepository;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\ReservationRepository;

require_once __DIR__ . '/database.php';

$builder = new ContainerBuilder();

$builder->useAutowiring(true);

$builder->addDefinitions([
    SalleRepositoryInterface::class => DI\get(SalleRepository::class),
    ReservationRepositoryInterface::class => DI\get(ReservationRepository::class),
]);

return $builder->build();