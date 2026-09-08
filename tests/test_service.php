<?php

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../config/database.php';

use App\DTO\CreerReservationDTOBuilder;
use App\Repository\SalleRepository;
use App\Repository\ReservationRepository;
use App\Service\CreerReservationService;
use App\Service\SalleIndisponibleException;
use App\Service\AnnulerReservationService;

$service = new CreerReservationService(
    new SalleRepository(),
    new ReservationRepository()
);

$dto = (new CreerReservationDTOBuilder())
    ->setSalleId(2)
    ->setResponsable("Test Service")
    ->setEmail("test@example.com")
    ->setMotif("Test réservation")
    ->setDateDebut(new DateTimeImmutable("+10 days 10:00"))
    ->setDateFin(new DateTimeImmutable("+10 days 12:00"))
    ->build();

$reservation = $service->execute($dto);

echo "Réservation créée avec succès !" . PHP_EOL;
echo "ID : " . $reservation->id . PHP_EOL;
echo "Statut : " . $reservation->statut . PHP_EOL;


echo PHP_EOL . "===== TEST CONFLIT =====" . PHP_EOL;

try {
   $dtoConflit = (new CreerReservationDTOBuilder())
    ->setSalleId(2)
    ->setResponsable("Deuxième réservation")
    ->setEmail("test2@example.com")
    ->setMotif("Test conflit")
    ->setDateDebut(new DateTimeImmutable("+10 days 11:00"))
    ->setDateFin(new DateTimeImmutable("+10 days 13:00"))
    ->build();

    $service->execute($dtoConflit);

    echo "ERREUR : le conflit n'a pas été détecté." . PHP_EOL;

} catch (SalleIndisponibleException $e) {

    echo "Conflit détecté correctement." . PHP_EOL;
}



echo PHP_EOL . "===== TEST ANNULATION =====" . PHP_EOL;


$annulerService = new AnnulerReservationService(
    new ReservationRepository()
);

$reservationAnnulee = $annulerService->execute($reservation->id);

echo "Réservation annulée : ";
echo $reservationAnnulee->statut . PHP_EOL;