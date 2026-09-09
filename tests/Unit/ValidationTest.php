<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Validation\ReservationValidator;
use App\Validation\SalleValidator;
use PHPUnit\Framework\TestCase;

class ValidationTest extends TestCase
{
    public function testEmailInvalide(): void
    {
        $validator = new ReservationValidator();

        $result = $validator->validate([
            'salle_id' => 1,
            'responsable' => 'Aissatou',
            'email' => 'email-invalide',
            'motif' => 'Réunion',
            'date_debut' => '2026-09-20 10:00:00',
            'date_fin' => '2026-09-20 12:00:00',
        ]);

        $this->assertFalse($result->isValid());
        $this->assertArrayHasKey('email', $result->errors());
    }

    public function testResponsableVide(): void
    {
        $validator = new ReservationValidator();

        $result = $validator->validate([
            'salle_id' => 1,
            'responsable' => '',
            'email' => 'aissatou@example.com',
            'motif' => 'Réunion',
            'date_debut' => '2026-09-20 10:00:00',
            'date_fin' => '2026-09-20 12:00:00',
        ]);

        $this->assertFalse($result->isValid());
        $this->assertArrayHasKey('responsable', $result->errors());
    }

    public function testCapaciteNegative(): void
    {
        $validator = new SalleValidator();

        $result = $validator->validate([
            'nom' => 'Salle A',
            'batiment' => 'A',
            'capacite' => -10,
            'type' => 'cours',
            'active' => true,
        ]);

        $this->assertFalse($result->isValid());
        $this->assertArrayHasKey('capacite', $result->errors());
    }

    public function testTypeSalleInconnu(): void
    {
        $validator = new SalleValidator();

        $result = $validator->validate([
            'nom' => 'Salle A',
            'batiment' => 'A',
            'capacite' => 30,
            'type' => 'type-inconnu',
            'active' => true,
        ]);

        $this->assertFalse($result->isValid());
        $this->assertArrayHasKey('type', $result->errors());
    }

    public function testDateInvalide(): void
    {
        $validator = new ReservationValidator();

        $result = $validator->validate([
            'salle_id' => 1,
            'responsable' => 'Aissatou',
            'email' => 'aissatou@example.com',
            'motif' => 'Réunion',
            'date_debut' => 'date-invalide',
            'date_fin' => '2026-09-20 12:00:00',
        ]);

        $this->assertFalse($result->isValid());
        $this->assertArrayHasKey('date_debut', $result->errors());
    }
    
}


