<?php
declare(strict_types=1);

    namespace App\Repository;

    use App\Model\Reservation;
    use App\DTO\CreerReservationDTO;
    use App\Repository\ReservationRepositoryInterface;
    use Illuminate\Database\Eloquent\Collection;

    class ReservationRepository implements ReservationRepositoryInterface
    {
        public function listerReservations(): Collection
        {
            return Reservation::with('salle')->get();
        }

        public function retrouverReservationParId(int $id): ?Reservation
        {
            return Reservation::with('salle')->find($id);
        }

        public function rechercherConflit(
            int $salleId,
            \DateTimeInterface $dateDebut,
            \DateTimeInterface $dateFin,
            ?int $reservationIdAExclure = null
        ): ?Reservation {
            $query = Reservation::query()
                ->where('salle_id', $salleId)
                ->where('statut', '!=', 'annulee')
                ->where(function ($q) use ($dateDebut, $dateFin) {
                    $q->where('date_debut', '<', $dateFin->format('Y-m-d H:i:s'))
                    ->where('date_fin', '>', $dateDebut->format('Y-m-d H:i:s'));
                });

            if ($reservationIdAExclure !== null) {
                $query->where('id', '!=', $reservationIdAExclure);
            }

            return $query->first();
        }

        public function enregistrerReservation(CreerReservationDTO $dto): Reservation
        {
            return Reservation::create($dto->toArray());
        }

        public function annulerReservation(int $id): bool
        {
            $reservation = $this->retrouverReservationParId($id);

            if (!$reservation) {
                return false;
            }

            return $reservation->update(['statut' => 'annulee']);
        }
    }