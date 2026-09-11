<?php

    declare(strict_types=1);

    namespace Tests\Units;

    use App\Validator\ReservationValidator;
    use App\Validator\SalleValidator;
    use PHPUnit\Framework\TestCase;

    class ValidatorsTest extends TestCase
    {
        private SalleValidator $salleValidator;
        private ReservationValidator $reservationValidator;

        protected function setUp(): void
        {
            $this->salleValidator = new SalleValidator();
            $this->reservationValidator = new ReservationValidator();
        }

        public function testBatimentManquant(): void
        {
            $result = $this->salleValidator->validate([
                'nom' => 'Salle Test',
                'capacite' => 20,
                'type' => 'reunion',
                'active' => true,
            ]);

            $this->assertFalse($result->isValid());
            $this->assertArrayHasKey('batiment', $result->errors());
        }

        public function testCapaciteNegative(): void
        {
            $result = $this->salleValidator->validate([
                'nom' => 'Salle Test',
                'batiment' => 'A',
                'capacite' => -5,
                'type' => 'reunion',
                'active' => true,
            ]);

            $this->assertFalse($result->isValid());
            $this->assertArrayHasKey('capacite', $result->errors());
        }

        public function testTypeSalleInconnu(): void
        {
            $result = $this->salleValidator->validate([
                'nom' => 'Salle Test',
                'batiment' => 'A',
                'capacite' => 20,
                'type' => 'inconnu',
                'active' => true,
            ]);

            $this->assertFalse($result->isValid());
            $this->assertArrayHasKey('type', $result->errors());
        }

        public function testDateIncorrecte(): void
        {
            $result = $this->reservationValidator->validate([
                'salle_id' => '1',
                'responsable' => 'Jean Dupont',
                'email' => 'jean@example.com',
                'motif' => 'Réunion équipe',
                'date_debut' => 'date-invalide',
                'date_fin' => '2026-10-10 12:00:00',
            ]);

            $this->assertFalse($result->isValid());
            $this->assertArrayHasKey('date_debut', $result->errors());
        }
    }