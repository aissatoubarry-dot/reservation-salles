<?php

declare(strict_types=1);

namespace Tests\Integration;

use App\Model\Reservation;
use App\Model\Salle;
use App\Repository\ReservationRepository;
use App\Repository\SalleRepository;
use DateTimeImmutable;
use Illuminate\Database\Capsule\Manager as Capsule;
use PHPUnit\Framework\TestCase;

class RepositoryTest extends TestCase
{
    private SalleRepository $salleRepository;
    private ReservationRepository $reservationRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $capsule = new Capsule();

        $capsule->addConnection([
            'driver' => 'mysql',
            'host' => $_ENV['DB_HOST'] ?? 'db',
            'port' => $_ENV['DB_PORT'] ?? 3306,
            'database' => $_ENV['DB_DATABASE'] ?? 'reservation_salles',
            'username' => $_ENV['DB_USERNAME'] ?? 'reservation_user',
            'password' => $_ENV['DB_PASSWORD'] ?? 'reservation123',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $this->salleRepository = new SalleRepository();
        $this->reservationRepository = new ReservationRepository();
    }

    public function testCreerUneSalleAvecEloquent(): void
    {
        $salle = new Salle();

        $salle->nom = 'Salle Test Integration';
        $salle->batiment = 'TEST';
        $salle->capacite = 20;
        $salle->type = 'cours';
        $salle->active = true;

        $salle = $this->salleRepository->enregistrer($salle);

        $this->assertNotNull($salle->id);
        $this->assertSame(
            'Salle Test Integration',
            $salle->nom
        );

        $salle->delete();
    }

    public function testRelationSalleReservations(): void
    {
        $salle = Salle::create([
            'nom' => 'Salle Relation Test',
            'batiment' => 'TEST',
            'capacite' => 20,
            'type' => 'cours',
            'active' => true,
        ]);

        $reservation = Reservation::create([
            'salle_id' => $salle->id,
            'responsable' => 'Test Integration',
            'email' => 'test@example.com',
            'motif' => 'Test relation',
            'date_debut' => new DateTimeImmutable('+5 days 10:00'),
            'date_fin' => new DateTimeImmutable('+5 days 12:00'),
            'statut' => 'confirmée',
        ]);

        $salle->load('reservations');

        $this->assertCount(1, $salle->reservations);
        $this->assertSame($reservation->id, $salle->reservations->first()->id);

        $reservation->delete();
        $salle->delete();
    }

    public function testRechercheDeChevauchement(): void
    {
        $salle = Salle::create([
            'nom' => 'Salle Conflit Test',
            'batiment' => 'TEST',
            'capacite' => 20,
            'type' => 'cours',
            'active' => true,
        ]);

        $reservation = Reservation::create([
            'salle_id' => $salle->id,
            'responsable' => 'Test Conflit',
            'email' => 'test@example.com',
            'motif' => 'Test conflit',
            'date_debut' => new DateTimeImmutable('+6 days 10:00'),
            'date_fin' => new DateTimeImmutable('+6 days 12:00'),
            'statut' => 'confirmée',
        ]);

        $conflit = $this->reservationRepository->rechercherConflit(
            $salle->id,
            new DateTimeImmutable('+6 days 11:00'),
            new DateTimeImmutable('+6 days 13:00')
        );

        $this->assertTrue($conflit);

        $reservation->delete();
        $salle->delete();
    }

    public function testAnnulationReservation(): void
    {
        $salle = Salle::create([
            'nom' => 'Salle Annulation Test',
            'batiment' => 'TEST',
            'capacite' => 20,
            'type' => 'cours',
            'active' => true,
        ]);

        $reservation = Reservation::create([
            'salle_id' => $salle->id,
            'responsable' => 'Test Annulation',
            'email' => 'test@example.com',
            'motif' => 'Test annulation',
            'date_debut' => new DateTimeImmutable('+7 days 10:00'),
            'date_fin' => new DateTimeImmutable('+7 days 12:00'),
            'statut' => 'confirmée',
        ]);

        $this->reservationRepository->annuler($reservation);

        $reservation->refresh();

        $this->assertSame('annulée', $reservation->statut);

        $reservation->delete();
        $salle->delete();
    }
}
