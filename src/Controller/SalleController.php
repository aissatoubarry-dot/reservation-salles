<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CreerSalleDTOBuilder;
use App\Model\Salle;
use App\Repository\SalleRepositoryInterface;
use App\Validation\SalleValidator;

final class SalleController
{
    public function __construct(
        private SalleRepositoryInterface $salleRepository,
        private SalleValidator $validator
    ) {
    }

 
    public function index(): void
    {
        $salles = $this->salleRepository->lister();

        ob_start();

        require dirname(__DIR__, 2) . '/templates/salle/index.php';

        $content = ob_get_clean();
        $title = 'Liste des salles';

        require dirname(__DIR__, 2) . '/templates/layout/base.php';
    }

    
    public function show(int $id): void
    {
        $salle = $this->salleRepository->trouver($id);

        if ($salle === null) {
            http_response_code(404);
            require dirname(__DIR__, 2) . '/templates/error/404.php';
            return;
        }

        ob_start();

        require dirname(__DIR__, 2) . '/templates/salle/show.php';

        $content = ob_get_clean();
        $title = 'Détail de la salle';

        require dirname(__DIR__, 2) . '/templates/layout/base.php';
    }
   
    public function create(): void
    {
        $salle = null;
        $errors = [];
        $data = [];
        $action = '/salles';

        ob_start();

        require dirname(__DIR__, 2) . '/templates/salle/form.php';

        $content = ob_get_clean();
        $title = 'Ajouter une salle';

        require dirname(__DIR__, 2) . '/templates/layout/base.php';
    }

    public function store(): void
    {
        $data = $_POST;

        $data['active'] = isset($data['active']);

        if (isset($data['capacite'])) {
            $data['capacite'] = (int) $data['capacite'];
        }

        $result = $this->validator->validate($data);

        if (!$result->isValid()) {
            $salle = null;
            $errors = $result->errors();
            $action = '/salles';

            require dirname(__DIR__, 2) . '/templates/salle/form.php';
            return;
        }

        $dto = (new CreerSalleDTOBuilder())
            ->setNom($data['nom'])
            ->setBatiment($data['batiment'])
            ->setCapacite($data['capacite'])
            ->setType($data['type'])
            ->setActive($data['active'])
            ->build();

        $salle = new Salle($dto->toArray());

        $this->salleRepository->enregistrer($salle);

        header('Location: /salles');
        exit;
    }

    
    public function edit(int $id): void
    {
        $salle = $this->salleRepository->trouver($id);

        if ($salle === null) {
            http_response_code(404);
            require dirname(__DIR__, 2) . '/templates/error/404.php';
            return;
        }

        $errors = [];
        $data = $salle->toArray();
        $action = '/salles/' . $id . '/edit';

        ob_start();

        require dirname(__DIR__, 2) . '/templates/salle/form.php';

        $content = ob_get_clean();
        $title = 'Modifier la salle';

        require dirname(__DIR__, 2) . '/templates/layout/base.php';
    }
   
    public function update(int $id): void
    {
        $salle = $this->salleRepository->trouver($id);

        if ($salle === null) {
            http_response_code(404);
            require dirname(__DIR__, 2) . '/templates/error/404.php';
            return;
        }

        $data = $_POST;

        $data['active'] = isset($data['active']);

        $result = $this->validator->validate($data);

        if (!$result->isValid()) {
            $errors = $result->errors();
            $data = array_merge($salle->toArray(), $data);
            $action = '/salles/' . $id . '/edit';

            require dirname(__DIR__, 2) . '/templates/salle/form.php';
            return;
        }

        $dto = (new CreerSalleDTOBuilder())
            ->setNom($data['nom'])
            ->setBatiment($data['batiment'])
            ->setCapacite((int) $data['capacite'])
            ->setType($data['type'])
            ->setActive($data['active'])
            ->build();

        $salle->fill($dto->toArray());

        $this->salleRepository->enregistrer($salle);

        header('Location: /salles/' . $id);
        exit;
    }
}