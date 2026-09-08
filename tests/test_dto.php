<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\DTO\CreerSalleDTOBuilder;
use App\DTO\CreerReservationDTOBuilder;
use App\Validation\SalleValidator;

// ============================
// TEST DTO SALLE
// ============================

$salle = (new CreerSalleDTOBuilder())
    ->setNom("Salle B12")
->setBatiment("Batiment B")
    ->setCapacite(40)
    ->setType("cours")
    ->setActive(true)
    ->build();

echo "===== TEST SALLE =====" . PHP_EOL;

$resultatSalle = (new SalleValidator())
    ->validate($salle->toArray());

echo "Salle : ";
echo $resultatSalle->isValid() ? "VALIDE" : "INVALIDE";
echo PHP_EOL;

echo "Erreurs :" . PHP_EOL;
var_dump($resultatSalle->errors());

echo "Nom : ";
var_dump($salle->getNom());

echo "Capacité : ";
var_dump($salle->getCapacite());

echo "Type : ";
var_dump($salle->getType());

echo "Active : ";
var_dump($salle->isActive());


// ============================
// TEST DTO RESERVATION
// ============================

$reservation = (new CreerReservationDTOBuilder())
    ->setSalleId(2)
    ->setResponsable("Aissatou Barry")
    ->setEmail("aissatou@example.com")
    ->setMotif("Cours de PHP")
    ->setDateDebut(
        new DateTimeImmutable("2026-09-10 10:00:00")
    )
    ->setDateFin(
        new DateTimeImmutable("2026-09-10 12:00:00")
    )
    ->build();

echo PHP_EOL;
echo "===== TEST RESERVATION =====" . PHP_EOL;

echo "Reservation : ";
echo $reservation->isValid() ? "VALIDE" : "INVALIDE";
echo PHP_EOL;

echo "Salle ID : ";
var_dump($reservation->getSalleId());

echo "Responsable : ";
var_dump($reservation->getResponsable());

echo "Email : ";
var_dump($reservation->getEmail());

echo "Motif : ";
var_dump($reservation->getMotif());

echo "Date début : ";
var_dump($reservation->getDateDebut());

echo "Date fin : ";
var_dump($reservation->getDateFin());