<?php

namespace App\Service;

use App\DTO\CreerReservationDTO;
use App\Model\Reservation;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use DateTimeImmutable;
use InvalidArgumentException;

class CreerReservationService
{
    public function __construct(
        private SalleRepositoryInterface $salleRepository,
        private ReservationRepositoryInterface $reservationRepository
    ) {
    }

    public function execute(CreerReservationDTO $dto): Reservation
    {
        $salle = $this->salleRepository->trouver($dto->getSalleId());

        if ($salle === null || !$salle->active) {
            throw new SalleIndisponibleException(
                "La salle est introuvable ou inactive."
            );
        }

        $dateDebut = $dto->getDateDebut();
        $dateFin = $dto->getDateFin();

        if ($dateDebut >= $dateFin) {
            throw new InvalidArgumentException(
                "La date de début doit précéder la date de fin."
            );
        }

        $duree = $dateFin->getTimestamp() - $dateDebut->getTimestamp();

        if ($duree > 4 * 60 * 60) {
            throw new InvalidArgumentException(
                "La réservation ne peut pas dépasser 4 heures."
            );
        }

        if ($dateDebut <= new DateTimeImmutable()) {
            throw new InvalidArgumentException(
                "La date de début doit être dans le futur."
            );
        }

        if (
            $this->reservationRepository->rechercherConflit(
                $dto->getSalleId(),
                $dateDebut,
                $dateFin
            )
        ) {
            throw new SalleIndisponibleException(
                "La salle est déjà réservée sur cette période."
            );
        }

        $reservation = new Reservation();

        $reservation->salle_id = $dto->getSalleId();
        $reservation->responsable = $dto->getResponsable();
        $reservation->email = $dto->getEmail();
        $reservation->motif = $dto->getMotif();
        $reservation->date_debut = $dateDebut;
        $reservation->date_fin = $dateFin;
        $reservation->statut = 'confirmée';

        return $this->reservationRepository->enregistrer($reservation);
    }
}