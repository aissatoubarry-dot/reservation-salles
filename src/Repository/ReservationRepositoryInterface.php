<?php

namespace App\Repository;

use App\Model\Reservation;
use DateTimeImmutable;

interface ReservationRepositoryInterface
{
    public function lister(): array;

    public function trouver(int $id): ?Reservation;

    public function rechercherConflit(
        int $salleId,
        DateTimeImmutable $dateDebut,
        DateTimeImmutable $dateFin
    ): bool;

    public function enregistrer(Reservation $reservation): Reservation;

    public function annuler(Reservation $reservation): Reservation;
}