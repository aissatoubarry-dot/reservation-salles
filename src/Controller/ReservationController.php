<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\CreerReservationDTOBuilder;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Service\CreerReservationService;
use App\Service\AnnulerReservationService;
use App\Exception\SalleIndisponibleException;
use App\Exception\ReservationIntrouvableException;
use App\Validation\ReservationValidatorInterface;
use DateTimeImmutable;
use App\Support\ResponseStrategyInterface;

class ReservationController
{
    public function __construct(
        private ReservationRepositoryInterface $reservationRepository,
        private SalleRepositoryInterface $salleRepository,
        private CreerReservationService $creerService,
        private AnnulerReservationService $annulerService,
        private ReservationValidatorInterface $validator,
        private ResponseStrategyInterface $response
    ) {
    }

    public function index(): void
    {
        $reservations = $this->reservationRepository->lister();

        $this->response->render(
            'reservation/index',
            [
                'title' => 'Liste des réservations',
                'reservations' => $reservations
            ]
        );
    }

    public function show(int $id): void
    {
        $reservation = $this->reservationRepository->trouver($id);

        if ($reservation === null) {

            $this->response->notFound();
            return;
        }

        $this->response->render(
            'reservation/show',
            [
                'title' => 'Détail de la réservation',
                'reservation' => $reservation
            ]
        );
    }

    public function create(): void
    {
        $salles = $this->salleRepository->lister();
        $errors = [];
        $data = [];

        $this->response->render(
            'reservation/form',
            [
                'title' => 'Nouvelle réservation',
                'salles' => $salles,
                'errors' => $errors,
                'data' => $data,
                'action' => '/reservations',
            ]
        );
    }

    public function store(): void
    {
        $data = $_POST;

        if (isset($data['salle_id'])) {
            $data['salle_id'] = (int) $data['salle_id'];
        }   

        if (!empty($data['date_debut'])) {
            $data['date_debut'] = str_replace('T', ' ', $data['date_debut']);

            if (strlen($data['date_debut']) === 16) {
                $data['date_debut'] .= ':00';
            }
        }

        if (!empty($data['date_fin'])) {
            $data['date_fin'] = str_replace('T', ' ', $data['date_fin']);

            if (strlen($data['date_fin']) === 16) {
                $data['date_fin'] .= ':00';
            }
        }

        $result = $this->validator->validate($data);

        if (!$result->isValid()) {
            $errors = $result->errors();
            $salles = $this->salleRepository->lister();

        $this->response->render(
            'reservation/form',
            [
                'title' => 'Nouvelle réservation',
                'salles' => $salles,
                'errors' => $errors,
                'data' => $data,
                'action' => '/reservations',
            ]
        );

            return;
        }

        $dto = (new CreerReservationDTOBuilder())
            ->setSalleId((int) $data['salle_id'])
            ->setResponsable($data['responsable'])
            ->setEmail($data['email'])
            ->setMotif($data['motif'])
            ->setDateDebut(new DateTimeImmutable($data['date_debut']))
            ->setDateFin(new DateTimeImmutable($data['date_fin']))
            ->build();

        try {
            $this->creerService->execute($dto);
        } catch (SalleIndisponibleException $e) {
            $errors['salle_id'][] = $e->getMessage();
            $salles = $this->salleRepository->lister();

        $this->response->render(
            'reservation/form',
            [
                'title' => 'Nouvelle réservation',
                'salles' => $salles,
                'errors' => $errors,
                'data' => $data,
                'action' => '/reservations',
            ]
        );

            return;
        }

        $this->response->redirect('/reservations');

    }



    public function cancel(int $id): void
    {
        try {
            $this->annulerService->execute($id);

            
        } catch (ReservationIntrouvableException $e) {

            $this->response->notFound();
            return;
        }

        $this->response->redirect('/reservations');

    }
    
}