<?php

namespace App\Service;

use App\Model\Reservation;
use App\Repository\ReservationRepositoryInterface;
use App\Exception\ReservationIntrouvableException;

class AnnulerReservationService
{
    public function __construct(
        private ReservationRepositoryInterface $reservationRepository
    ) {
    }

    public function execute(int $id): Reservation
    {
        $reservation = $this->reservationRepository->trouver($id);

        if ($reservation === null) {
            throw new ReservationIntrouvableException(
                "La réservation est introuvable."
            );
        }

        return $this->reservationRepository->annuler($reservation);
    }
}


