<?php

namespace App\Controller;

use App\DTO\CreerSalleDTOBuilder;
use App\Repository\SalleRepositoryInterface;
use App\Validation\SalleValidator;

class SalleController
{
    public function __construct(
        private SalleRepositoryInterface $salleRepository,
        private SalleValidator $validator
    ) {
    }

    public function index(): void
    {
        $salles = $this->salleRepository->lister();

        require __DIR__ . '/../../templates/salle/index.php';
    }

    public function show(int $id): void
    {
        $salle = $this->salleRepository->trouver($id);

        if ($salle === null) {
            http_response_code(404);
            require __DIR__ . '/../../templates/error/404.php';
            return;
        }

        require __DIR__ . '/../../templates/salle/show.php';
    }

    public function create(): void
    {
        $errors = [];
        $data = [];

        require __DIR__ . '/../../templates/salle/form.php';
    }

    public function store(): void
    {
        $data = $_POST;

        $result = $this->validator->validate($data);

        if (!$result->isValid()) {
            $errors = $result->errors();

            require __DIR__ . '/../../templates/salle/form.php';
            return;
        }

        $dto = (new CreerSalleDTOBuilder())
            ->setNom($data['nom'])
            ->setBatiment($data['batiment'])
            ->setCapacite((int) $data['capacite'])
            ->setType($data['type'])
            ->setActive(isset($data['active']))
            ->build();

        $salle = new \App\Model\Salle($dto->toArray());

        $this->salleRepository->enregistrer($salle);

        header('Location: /salles');
        exit;
    }

    public function edit(int $id): void
    {
        $salle = $this->salleRepository->trouver($id);

        if ($salle === null) {
            http_response_code(404);
            require __DIR__ . '/../../templates/error/404.php';
            return;
        }

        $errors = [];
        $data = $salle->toArray();

        require __DIR__ . '/../../templates/salle/form.php';
    }

    public function update(int $id): void
    {
        $salle = $this->salleRepository->trouver($id);

        if ($salle === null) {
            http_response_code(404);
            require __DIR__ . '/../../templates/error/404.php';
            return;
        }

        $data = $_POST;

        $result = $this->validator->validate($data);

        if (!$result->isValid()) {
            $errors = $result->errors();

            require __DIR__ . '/../../templates/salle/form.php';
            return;
        }

        $salle->nom = $data['nom'];
        $salle->batiment = $data['batiment'];
        $salle->capacite = (int) $data['capacite'];
        $salle->type = $data['type'];
        $salle->active = isset($data['active']);

        $this->salleRepository->enregistrer($salle);

        header('Location: /salles/' . $id);
        exit;
    }
}