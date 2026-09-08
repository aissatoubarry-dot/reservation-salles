<?php

namespace App\Repository;

use App\Model\Salle;

interface SalleRepositoryInterface
{
    public function lister(): array;

    public function trouver(int $id): ?Salle;

    public function enregistrer(Salle $salle): Salle;
}