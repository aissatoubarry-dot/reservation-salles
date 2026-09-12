<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CreerSalleDTOBuilder;
use App\Model\Salle;
use App\Repository\SalleRepositoryInterface;
use App\Validation\SalleValidatorInterface;
use App\Support\ResponseStrategyInterface;


final class SalleController
{
    public function __construct(
        private SalleRepositoryInterface $salleRepository,
        private SalleValidatorInterface $validator,
        private ResponseStrategyInterface $response
    ) {
    }

 
    public function index(): void
    {
        $salles = $this->salleRepository->lister(5);

        $pagination = [
            'currentPage' => $salles->currentPage(),
            'lastPage' => $salles->lastPage(),
            'previousPageUrl' => $salles->currentPage() > 1
                ? '/salles?page=' . ($salles->currentPage() - 1)
                : null,
            'nextPageUrl' => $salles->currentPage() < $salles->lastPage()
                ? '/salles?page=' . ($salles->currentPage() + 1)
                : null,
            'pages' => [],
        ];

        for ($page = 1; $page <= $salles->lastPage(); $page++) {
            $pagination['pages'][] = [
                'number' => $page,
                'url' => '/salles?page=' . $page,
                'current' => $page === $salles->currentPage(),
            ];
        }

        $this->response->render('salle/index', [
            'title' => 'Liste des salles',
            'salles' => $salles,
            'pagination' => $pagination,
        ]);
    }

    
    public function show(int $id): void
    {
        $salle = $this->salleRepository->trouver($id);

        if ($salle === null) {

            $this->response->notFound();
            return;
        }

        $this->response->render(
            'salle/show',
            [
                'title' => 'Détail de la salle',
                'salle' => $salle
            ]
        );
    }
    
   
    public function create(): void
    {
        $salle = null;
        $errors = [];
        $data = [];

        $this->response->render(
            'salle/form',
            [
                'title' => 'Ajouter une salle',
                'salle' => $salle,
                'errors' => $errors,
                'data' => $data,
                'action' => '/salles',
            ]
        );
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

            $this->response->render(
                'salle/form',
                [
                    'salle' => $salle,
                    'errors' => $errors,
                    'data' => $data,
                    'action' => '/salles',
                ]
            );

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

        $this->response->redirect('/salles');

        
    }

    
    public function edit(int $id): void
    {
        $salle = $this->salleRepository->trouver($id);

        if ($salle === null) {

            $this->response->notFound();
            return;
        }

        $errors = [];
        $data = $salle->toArray();

        $this->response->render(
            'salle/form',
            [
                'salle' => $salle,
                'errors' => $errors,
                'data' => $data,
                'action' => '/salles/' . $id . '/edit',
            ]
        );
    }
   
    public function update(int $id): void
    {
        $salle = $this->salleRepository->trouver($id);

        if ($salle === null) {
            $this->response->notFound();
            return;
        }

        $data = $_POST;

        $data['active'] = isset($data['active']);

        $result = $this->validator->validate($data);


        if (!$result->isValid()) {
            $errors = $result->errors();
            $data = array_merge($salle->toArray(), $data);

            $this->response->render(
                'salle/form',
                [
                    'salle' => $salle,
                    'errors' => $errors,
                    'data' => $data,
                    'action' => '/salles/' . $id . '/edit',
                ]
            );

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

        $this->response->redirect('/salles/' . $id);

    }
}