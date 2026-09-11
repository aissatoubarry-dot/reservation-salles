<?php

namespace App\DTO;

use App\Validation\ReservationValidator;

readonly class CreerReservationDTO
{
    public function __construct(
        private int $salleId,
        private string $responsable,
        private string $email,
        private string $motif,
        private \DateTimeImmutable $dateDebut,
        private \DateTimeImmutable $dateFin
    ) {
    }

    public function isValid(): bool
    {
        $validator = new ReservationValidator();

        return $validator->validate($this->toArray())->isValid();
    }

    public function toArray(): array
    {
        return [
            'salle_id' => $this->salleId,
            'responsable' => $this->responsable,
            'email' => $this->email,
            'motif' => $this->motif,
            'date_debut' => $this->dateDebut->format('Y-m-d H:i:s'),
            'date_fin' => $this->dateFin->format('Y-m-d H:i:s'),
        ];
    }

    public function getSalleId(): int
    {
        return $this->salleId;
    }

    public function getResponsable(): string
    {
        return $this->responsable;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getMotif(): string
    {
        return $this->motif;
    }

    public function getDateDebut(): \DateTimeImmutable
    {
        return $this->dateDebut;
    }

    public function getDateFin(): \DateTimeImmutable
    {
        return $this->dateFin;
    }
}