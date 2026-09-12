<?php

namespace App\Repository;

use App\Model\Salle;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class SalleRepository implements SalleRepositoryInterface
{
    public function lister(int $perPage = 5): LengthAwarePaginator
    {
        Paginator::currentPageResolver(function (): int {
            return max(1, (int) ($_GET['page'] ?? 1));
        });

        return Salle::query()
            ->orderBy('id')
            ->paginate($perPage);
    }

    public function trouver(int $id): ?Salle
    {
        return Salle::find($id);
    }

    public function enregistrer(Salle $salle): Salle
    {
        $salle->save();

        return $salle;
    }
}