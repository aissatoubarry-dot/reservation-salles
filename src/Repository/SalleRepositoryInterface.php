<?php

namespace App\Repository;

use App\Model\Salle;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface SalleRepositoryInterface
{
    public function lister(int $perPage = 5): LengthAwarePaginator;

    public function trouver(int $id): ?Salle;

    public function enregistrer(Salle $salle): Salle;
}