<?php
    declare(strict_types=1);

    namespace App\Repository;

    use App\Model\Reservation;
    use Illuminate\Database\Eloquent\Collection;
    use DateTimeInterface;

    interface ReservationRepositoryInterface
    {

        public function listerReservations(): Collection;


        public function retrouverReservationParId(int $id): ?Reservation;


        public function rechercherConflit(
            int $salleId,
            DateTimeInterface $dateDebut,
            DateTimeInterface $dateFin,
            ?int $reservationIdAExclure = null
        ): ?Reservation;

        public function enregistrerReservation(Reservation $dto): Reservation;

        public function annulerReservation(int $id): bool;
    }