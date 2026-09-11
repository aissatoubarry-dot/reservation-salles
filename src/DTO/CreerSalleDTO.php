<?php

namespace App\DTO;

use App\Validation\SalleValidator;

readonly class CreerSalleDTO
{
    public function __construct(
        private string $nom,
        private string $batiment,
        private int $capacite,
        private string $type,
        private bool $active
    ) {
    }

    public function isValid(): bool
    {
        $validator = new SalleValidator();

        return $validator->validate($this->toArray())->isValid();
    }

    public function toArray(): array
    {
        return [
            'nom' => $this->nom,
            'batiment' => $this->batiment,
            'capacite' => $this->capacite,
            'type' => $this->type,
            'active' => $this->active,
        ];
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getBatiment(): string
    {
        return $this->batiment;
    }

    public function getCapacite(): int
    {
        return $this->capacite;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function isActive(): bool
    {
        return $this->active;
    }
}


