<?php

declare(strict_types=1);

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

        ob_start();

        require dirname(__DIR__, 2) . '/templates/reservation/index.php';

        $content = ob_get_clean();
        $title = 'Liste des réservations';

        require dirname(__DIR__, 2) . '/templates/layout/base.php';
    }

    public function show(int $id): void
    {
        $reservation = $this->reservationRepository->trouver($id);

        if ($reservation === null) {
            http_response_code(404);
            require dirname(__DIR__, 2) . '/templates/error/404.php';
            return;
        }

        ob_start();

        require dirname(__DIR__, 2) . '/templates/reservation/show.php';

        $content = ob_get_clean();
        $title = 'Détail de la réservation';

        require dirname(__DIR__, 2) . '/templates/layout/base.php';
    }

    public function create(): void
    {
        $salles = $this->salleRepository->lister();
        $errors = [];
        $data = [];
        $action = '/reservations';

        ob_start();

        require dirname(__DIR__, 2) . '/templates/reservation/form.php';

        $content = ob_get_clean();
        $title = 'Nouvelle réservation';

        require dirname(__DIR__, 2) . '/templates/layout/base.php';
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
            $action = '/reservations';

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
            $action = '/reservations';

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