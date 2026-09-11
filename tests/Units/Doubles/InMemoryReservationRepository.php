<?php

    declare(strict_types=1);

    namespace Tests\Units\Doubles;

    use App\Model\Reservation;
    use App\Repository\ReservationRepositoryInterface;
    use DateTimeInterface;
    use Illuminate\Database\Eloquent\Collection;

    class InMemoryReservationRepository implements ReservationRepositoryInterface
    {
        private array $reservations = [];

        public function listerReservations(): Collection
        {
            return new Collection(array_values($this->reservations));
        }

        public function retrouverReservationParId(int $id): ?Reservation
        {
            return $this->reservations[$id] ?? null;
        }

        public function rechercherConflit(
            int $salleId,
            DateTimeInterface $dateDebut,
            DateTimeInterface $dateFin,
            ?int $reservationIdAExclure = null
        ): ?Reservation {
            foreach ($this->reservations as $reservation) {
                if ($reservation->salle_id !== $salleId || $reservation->statut === 'annulee') {
                    continue;
                }

                if ($reservationIdAExclure !== null && $reservation->id === $reservationIdAExclure) {
                    continue;
                }

                if ($dateDebut < $reservation->date_fin && $dateFin > $reservation->date_debut) {
                    return $reservation;
                }
            }

            return null;
        }

        public function enregistrerReservation(Reservation $reservation): Reservation
        {
            if ($reservation->id === null) {
                $id = count($this->reservations) + 1;
                $reservation->id = $id;
            }

            $this->reservations[$reservation->id] = $reservation;

            return $reservation;
        }

        public function annulerReservation(int $id): bool
        {
            if (!isset($this->reservations[$id])) {
                return false;
            }

            $this->reservations[$id]->statut = 'annulee';

            return true;
        }
    }