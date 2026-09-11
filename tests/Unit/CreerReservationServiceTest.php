<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\DTO\CreerReservationDTOBuilder;
use App\Model\Salle;
use App\Model\Reservation;
use App\Repository\ReservationRepositoryInterface;
use App\Repository\SalleRepositoryInterface;
use App\Service\CreerReservationService;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Capsule\Manager as Capsule;
use App\Exception\SalleIndisponibleException;

class CreerReservationServiceTest extends TestCase
{
    public function testCreerUneReservationValide(): void
    {
        $salleRepository = $this->createMock(SalleRepositoryInterface::class);

        $salle = new Salle();
        $salle->id = 1;
        $salle->active = true;

        $salleRepository
            ->expects($this->once())
            ->method('trouver')
            ->with(1)
            ->willReturn($salle);

        $reservationRepository = $this->createMock(
            ReservationRepositoryInterface::class
        );

        $reservationRepository
            ->expects($this->once())
            ->method('rechercherConflit')
            ->willReturn(false);

        $reservationRepository
            ->expects($this->once())
            ->method('enregistrer')
            ->willReturnCallback(
                fn (Reservation $reservation) => $reservation
            );

        $service = new CreerReservationService(
            $salleRepository,
            $reservationRepository
        );

        $dto = (new CreerReservationDTOBuilder())
            ->setSalleId(1)
            ->setResponsable('Aissatou')
            ->setEmail('aissatou@example.com')
            ->setMotif('Réunion pédagogique')
            ->setDateDebut(new \DateTimeImmutable('+2 days 10:00'))
            ->setDateFin(new \DateTimeImmutable('+2 days 12:00'))
            ->build();

        $reservation = $service->execute($dto);

        $this->assertInstanceOf(Reservation::class, $reservation);
        $this->assertSame(1, $reservation->salle_id);
        $this->assertSame('Aissatou', $reservation->responsable);
        $this->assertSame('aissatou@example.com', $reservation->email);
        $this->assertSame('confirmée', $reservation->statut);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $capsule = new Capsule();

        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

    public function testSalleInexistante(): void
{
    $salleRepository = $this->createMock(SalleRepositoryInterface::class);

    $salleRepository
        ->expects($this->once())
        ->method('trouver')
        ->with(99)
        ->willReturn(null);

    $reservationRepository = $this->createMock(
        ReservationRepositoryInterface::class
    );

    $service = new CreerReservationService(
        $salleRepository,
        $reservationRepository
    );

    $dto = (new CreerReservationDTOBuilder())
        ->setSalleId(99)
        ->setResponsable('Aissatou')
        ->setEmail('aissatou@example.com')
        ->setMotif('Réunion pédagogique')
        ->setDateDebut(new \DateTimeImmutable('+2 days 10:00'))
        ->setDateFin(new \DateTimeImmutable('+2 days 12:00'))
        ->build();

    $this->expectException(SalleIndisponibleException::class);

    $service->execute($dto);
}


public function testSalleInactive(): void
{
    $salleRepository = $this->createMock(SalleRepositoryInterface::class);

    $salle = new Salle();
    $salle->id = 2;
    $salle->active = false;

    $salleRepository
        ->expects($this->once())
        ->method('trouver')
        ->with(2)
        ->willReturn($salle);

    $reservationRepository = $this->createMock(
        ReservationRepositoryInterface::class
    );

    $service = new CreerReservationService(
        $salleRepository,
        $reservationRepository
    );

    $dto = (new CreerReservationDTOBuilder())
        ->setSalleId(2)
        ->setResponsable('Aissatou')
        ->setEmail('aissatou@example.com')
        ->setMotif('Réunion pédagogique')
        ->setDateDebut(new \DateTimeImmutable('+2 days 10:00'))
        ->setDateFin(new \DateTimeImmutable('+2 days 12:00'))
        ->build();

    $this->expectException(SalleIndisponibleException::class);

    $service->execute($dto);
}



public function testDateFinAvantDateDebut(): void
{
    $salleRepository = $this->createMock(SalleRepositoryInterface::class);

    $salle = new Salle();
    $salle->id = 1;
    $salle->active = true;

    $salleRepository
        ->expects($this->once())
        ->method('trouver')
        ->with(1)
        ->willReturn($salle);

    $reservationRepository = $this->createMock(
        ReservationRepositoryInterface::class
    );

    $service = new CreerReservationService(
        $salleRepository,
        $reservationRepository
    );

    $dto = (new CreerReservationDTOBuilder())
        ->setSalleId(1)
        ->setResponsable('Aissatou')
        ->setEmail('aissatou@example.com')
        ->setMotif('Réunion pédagogique')
        ->setDateDebut(new \DateTimeImmutable('+2 days 14:00'))
        ->setDateFin(new \DateTimeImmutable('+2 days 12:00'))
        ->build();

    $this->expectException(\InvalidArgumentException::class);

    $service->execute($dto);
}




public function testDureeSuperieureAQuatreHeures(): void
{
    $salleRepository = $this->createMock(SalleRepositoryInterface::class);

    $salle = new Salle();
    $salle->id = 1;
    $salle->active = true;

    $salleRepository
        ->expects($this->once())
        ->method('trouver')
        ->with(1)
        ->willReturn($salle);

    $reservationRepository = $this->createMock(
        ReservationRepositoryInterface::class
    );

    $service = new CreerReservationService(
        $salleRepository,
        $reservationRepository
    );

    $dto = (new CreerReservationDTOBuilder())
        ->setSalleId(1)
        ->setResponsable('Aissatou')
        ->setEmail('aissatou@example.com')
        ->setMotif('Réunion pédagogique')
        ->setDateDebut(new \DateTimeImmutable('+2 days 10:00'))
        ->setDateFin(new \DateTimeImmutable('+2 days 15:00'))
        ->build();

    $this->expectException(\InvalidArgumentException::class);

    $service->execute($dto);
}



public function testDateDansLePasse(): void
{
    $salleRepository = $this->createMock(SalleRepositoryInterface::class);

    $salle = new Salle();
    $salle->id = 1;
    $salle->active = true;

    $salleRepository
        ->expects($this->once())
        ->method('trouver')
        ->with(1)
        ->willReturn($salle);

    $reservationRepository = $this->createMock(
        ReservationRepositoryInterface::class
    );

    $service = new CreerReservationService(
        $salleRepository,
        $reservationRepository
    );

    $dto = (new CreerReservationDTOBuilder())
        ->setSalleId(1)
        ->setResponsable('Aissatou')
        ->setEmail('aissatou@example.com')
        ->setMotif('Réunion pédagogique')
        ->setDateDebut(new \DateTimeImmutable('-1 day'))
        ->setDateFin(new \DateTimeImmutable('+1 hour'))
        ->build();

    $this->expectException(\InvalidArgumentException::class);

    $service->execute($dto);
}


public function testConflitDeReservation(): void
{
    $salleRepository = $this->createMock(SalleRepositoryInterface::class);

    $salle = new Salle();
    $salle->id = 1;
    $salle->active = true;

    $salleRepository
        ->expects($this->once())
        ->method('trouver')
        ->with(1)
        ->willReturn($salle);

    $reservationRepository = $this->createMock(
        ReservationRepositoryInterface::class
    );

    $reservationRepository
        ->expects($this->once())
        ->method('rechercherConflit')
        ->willReturn(true);

    $reservationRepository
        ->expects($this->never())
        ->method('enregistrer');

    $service = new CreerReservationService(
        $salleRepository,
        $reservationRepository
    );

    $dto = (new CreerReservationDTOBuilder())
        ->setSalleId(1)
        ->setResponsable('Aissatou')
        ->setEmail('aissatou@example.com')
        ->setMotif('Réunion pédagogique')
        ->setDateDebut(new \DateTimeImmutable('+2 days 10:00'))
        ->setDateFin(new \DateTimeImmutable('+2 days 12:00'))
        ->build();

    $this->expectException(SalleIndisponibleException::class);

    $service->execute($dto);
}



public function testReservationsAdjacentesNeSontPasEnConflit(): void
{
    $salleRepository = $this->createMock(SalleRepositoryInterface::class);

    $salle = new Salle();
    $salle->id = 1;
    $salle->active = true;

    $salleRepository
        ->expects($this->once())
        ->method('trouver')
        ->with(1)
        ->willReturn($salle);

    $reservationRepository = $this->createMock(
        ReservationRepositoryInterface::class
    );

    $reservationRepository
        ->expects($this->once())
        ->method('rechercherConflit')
        ->with(
            1,
            $this->isInstanceOf(\DateTimeImmutable::class),
            $this->isInstanceOf(\DateTimeImmutable::class)
        )
        ->willReturn(false);

    $reservationRepository
        ->expects($this->once())
        ->method('enregistrer')
        ->willReturnCallback(
            fn (Reservation $reservation) => $reservation
        );

    $service = new CreerReservationService(
        $salleRepository,
        $reservationRepository
    );

    $dto = (new CreerReservationDTOBuilder())
        ->setSalleId(1)
        ->setResponsable('Aissatou')
        ->setEmail('aissatou@example.com')
        ->setMotif('Réunion pédagogique')
        ->setDateDebut(new \DateTimeImmutable('+2 days 12:00'))
        ->setDateFin(new \DateTimeImmutable('+2 days 14:00'))
        ->build();

    $reservation = $service->execute($dto);

    $this->assertInstanceOf(Reservation::class, $reservation);
    $this->assertSame(1, $reservation->salle_id);
    $this->assertSame('confirmée', $reservation->statut);
}


}
