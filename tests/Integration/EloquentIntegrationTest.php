<?php

    declare(strict_types=1);

    namespace Tests\Integration;

    use App\Model\Reservation;
    use App\Model\Salle;
    use App\Repository\ReservationRepository;
    use App\Repository\SalleRepository;
    use DateTimeImmutable;
    use Illuminate\Database\Capsule\Manager as DB;
    use PHPUnit\Framework\TestCase;

    class EloquentIntegrationTest extends TestCase
    {
        private SalleRepository $salleRepository;
        private ReservationRepository $reservationRepository;

        protected function setUp(): void
        {
            $db = new DB();
            $db->addConnection([
                'driver'   => 'sqlite',
                'database' => ':memory:',
                'prefix'   => '',
            ]);
            $db->setAsGlobal();
            $db->bootEloquent();

            DB::schema()->create('salles', function ($table) {
                $table->increments('id');
                $table->string('nom');
                $table->integer('capacite');
                $table->text('description')->nullable();
                $table->timestamps();
            });

            DB::schema()->create('reservations', function ($table) {
                $table->increments('id');
                $table->integer('user_id')->nullable();
                $table->integer('salle_id');
                $table->dateTime('date_debut');
                $table->dateTime('date_fin');
                $table->string('statut')->default('en_attente');
                $table->timestamps();
            });

            $this->salleRepository = new SalleRepository();
            $this->reservationRepository = new ReservationRepository();
        }

        public function testCreationSalleAvecEloquent(): void
        {
            $salle = new Salle();
            $salle->fill(['nom' => 'Salle Eloquent', 'capacite' => 30]);
            $salleEnregistree = $this->salleRepository->enregistrerSalle($salle);

            $this->assertNotNull($salleEnregistree->id);
            $this->assertEquals('Salle Eloquent', $salleEnregistree->nom);
        }

        public function testRelationSalleReservations(): void
        {
            $salle = $this->salleRepository->enregistrerSalle(
                $this->createSalle('Salle B', 15)
            );

            $res1 = $this->createReservation($salle->id, '+1 day 10:00:00', '+1 day 11:00:00');
            $res2 = $this->createReservation($salle->id, '+1 day 14:00:00', '+1 day 15:00:00');

            $this->reservationRepository->enregistrerReservation($res1);
            $this->reservationRepository->enregistrerReservation($res2);

            $reservations = $this->reservationRepository->listerReservations();
            $this->assertCount(2, $reservations);
        }

        public function testRechercheDeChevauchement(): void
        {
            $salle = $this->salleRepository->enregistrerSalle(
                $this->createSalle('Salle C', 20)
            );

            $this->reservationRepository->enregistrerReservation(
                $this->createReservation($salle->id, '+1 day 10:00:00', '+1 day 12:00:00')
            );

            $conflit = $this->reservationRepository->rechercherConflit(
                $salle->id,
                new DateTimeImmutable('+1 day 11:00:00'),
                new DateTimeImmutable('+1 day 13:00:00')
            );

            $this->assertNotNull($conflit);
        }

        public function testAnnulationReservation(): void
        {
            $salle = $this->salleRepository->enregistrerSalle(
                $this->createSalle('Salle D', 20)
            );

            $res = $this->reservationRepository->enregistrerReservation(
                $this->createReservation($salle->id, '+1 day 10:00:00', '+1 day 11:00:00')
            );

            $succes = $this->reservationRepository->annulerReservation($res->id);
            $resAnnulee = $this->reservationRepository->retrouverReservationParId($res->id);

            $this->assertTrue($succes);
            $this->assertEquals('annulee', $resAnnulee->statut);
        }

        private function createSalle(string $nom, int $capacite): Salle
        {
            $salle = new Salle();
            $salle->fill(['nom' => $nom, 'capacite' => $capacite]);

            return $salle;
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
