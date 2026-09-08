<?php

namespace App\Controller;

use App\DTO\CreerReservationDTOBuilder;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Service\CreerReservationService;
use App\Service\AnnulerReservationService;
use App\Service\SalleIndisponibleException;
use App\Service\ReservationIntrouvableException;
use App\Validation\ReservationValidator;
use DateTimeImmutable;

class ReservationController
{
    public function __construct(
        private ReservationRepositoryInterface $reservationRepository,
        private SalleRepositoryInterface $salleRepository,
        private CreerReservationService $creerService,
        private AnnulerReservationService $annulerService,
        private ReservationValidator $validator
    ) {
    }

    public function index(): void
    {
        $reservations = $this->reservationRepository->lister();

        require __DIR__ . '/../../templates/reservation/index.php';
    }

    public function show(int $id): void
    {
        $reservation = $this->reservationRepository->trouver($id);

        if ($reservation === null) {
            http_response_code(404);
            require __DIR__ . '/../../templates/error/404.php';
            return;
        }

        require __DIR__ . '/../../templates/reservation/show.php';
    }

    public function create(): void
    {
        $salles = $this->salleRepository->lister();
        $errors = [];
        $data = [];

        require __DIR__ . '/../../templates/reservation/form.php';
    }

    public function store(): void
    {
        $data = $_POST;

        $result = $this->validator->validate($data);

        if (!$result->isValid()) {
            $errors = $result->errors();
            $salles = $this->salleRepository->lister();

            require __DIR__ . '/../../templates/reservation/form.php';
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

            require __DIR__ . '/../../templates/reservation/form.php';
            return;
        }

        header('Location: /reservations');
        exit;
    }

    public function cancel(int $id): void
    {
        try {
            $this->annulerService->execute($id);
        } catch (ReservationIntrouvableException $e) {
            http_response_code(404);
            require __DIR__ . '/../../templates/error/404.php';
            return;
        }

        header('Location: /reservations');
        exit;
    }
}