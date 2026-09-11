<?php

    declare(strict_types=1);

    namespace Tests\Units;

    use App\DTO\CreerReservationDTO;
    use App\Exception\RegleMetierException;
    use App\Exception\SalleIndisponibleException;
    use App\Model\Reservation;
    use App\Model\Salle;
    use App\Service\ReservationService;
    use DateTimeImmutable;
    use PHPUnit\Framework\TestCase;
    use Tests\Units\Doubles\InMemoryReservationRepository;
    use Tests\Units\Doubles\InMemorySalleRepository;

    class ReservationServiceTest extends TestCase
    {
        private InMemorySalleRepository $salleRepository;
        private InMemoryReservationRepository $reservationRepository;
        private ReservationService $reservationService;

        protected function setUp(): void
        {
            $this->salleRepository = new InMemorySalleRepository();
            $this->reservationRepository = new InMemoryReservationRepository();
            $this->reservationService = new ReservationService(
                $this->reservationRepository,
                $this->salleRepository
            );
        }

        public function testCreerReservationValide(): void
        {
            $salle = $this->createSalle(1, true);
            $this->salleRepository->enregistrerSalle($salle);

            $dto = $this->createReservationDto(1, '+1 day 10:00:00', '+1 day 12:00:00');

            $reservation = $this->reservationService->enregistrerReservation($dto);

            $this->assertNotNull($reservation->id);
            $this->assertSame(1, $reservation->salle_id);
        }

        public function testCreerReservationSalleInexistante(): void
        {
            $this->expectException(SalleIndisponibleException::class);

            $dto = $this->createReservationDto(999, '+1 day 10:00:00', '+1 day 12:00:00');

            $this->reservationService->enregistrerReservation($dto);
        }

        public function testCreerReservationSalleInactive(): void
        {
            $salle = $this->createSalle(2, false);
            $this->salleRepository->enregistrerSalle($salle);

            $this->expectException(SalleIndisponibleException::class);

            $dto = $this->createReservationDto(2, '+1 day 10:00:00', '+1 day 12:00:00');

            $this->reservationService->enregistrerReservation($dto);
        }

        public function testCreerReservationDateFinAnterieure(): void
        {
            $salle = $this->createSalle(3, true);
            $this->salleRepository->enregistrerSalle($salle);

            $this->expectException(RegleMetierException::class);

            $dto = $this->createReservationDto(3, '+1 day 12:00:00', '+1 day 10:00:00');

            $this->reservationService->enregistrerReservation($dto);
        }

        public function testCreerReservationDureeSuperieureQuatreHeures(): void
        {
            $salle = $this->createSalle(4, true);
            $this->salleRepository->enregistrerSalle($salle);

            $this->expectException(RegleMetierException::class);

            $dto = $this->createReservationDto(4, '+1 day 08:00:00', '+1 day 13:00:00');

            $this->reservationService->enregistrerReservation($dto);
        }

        public function testCreerReservationDatePassee(): void
        {
            $salle = $this->createSalle(5, true);
            $this->salleRepository->enregistrerSalle($salle);

            $this->expectException(RegleMetierException::class);

            $dto = $this->createReservationDto(5, '-1 day 10:00:00', '-1 day 12:00:00');

            $this->reservationService->enregistrerReservation($dto);
        }

        public function testCreerReservationConflit(): void
        {
            $salle = $this->createSalle(6, true);
            $this->salleRepository->enregistrerSalle($salle);

            $resExistante = $this->createReservation(6, '+1 day 10:00:00', '+1 day 12:00:00');
            $this->reservationRepository->enregistrerReservation($resExistante);

            $this->expectException(SalleIndisponibleException::class);

            $dto = $this->createReservationDto(6, '+1 day 11:00:00', '+1 day 13:00:00');

            $this->reservationService->enregistrerReservation($dto);
        }

        public function testCreerReservationVoisine(): void
        {
            $salle = $this->createSalle(7, true);
            $this->salleRepository->enregistrerSalle($salle);

            $resExistante = $this->createReservation(7, '+1 day 10:00:00', '+1 day 12:00:00');
            $this->reservationRepository->enregistrerReservation($resExistante);

            $dto = $this->createReservationDto(7, '+1 day 12:00:00', '+1 day 14:00:00');

            $reservation = $this->reservationService->enregistrerReservation($dto);

            $this->assertNotNull($reservation->id);
            $this->assertSame(7, $reservation->salle_id);
        }

        private function createSalle(int $id, bool $active): Salle
        {
            $salle = new Salle();
            $salle->fill(['nom' => 'Salle ' . $id, 'capacite' => 20]);
            $salle->id = $id;
            $salle->active = $active;

            return $salle;
        }

        private function createReservationDto(int $salleId, string $debut, string $fin): CreerReservationDTO
        {
            return new CreerReservationDTO(
                salleId: $salleId,
                responsable: 'Jean Dupont',
                email: 'jean@example.com',
                motif: 'Réunion',
                dateDebut: new DateTimeImmutable($debut),
                dateFin: new DateTimeImmutable($fin)
            );
        }

        private function createReservation(int $salleId, string $debut, string $fin): Reservation
        {
            $reservation = new Reservation();
            $reservation->fill([
                'salle_id' => $salleId,
                'date_debut' => new DateTimeImmutable($debut),
                'date_fin' => new DateTimeImmutable($fin),
                'statut' => 'confirmee',
            ]);

            return $reservation;
        }
    }
