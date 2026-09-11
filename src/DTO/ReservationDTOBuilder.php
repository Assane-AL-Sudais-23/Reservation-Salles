<?php
    declare(strict_types=1);

    namespace App\DTO;

    use App\Model\Reservation;
    use Illuminate\Support\Collection;

    final class ReservationDTOBuilder
    {
        public static function fromEntity(Reservation $reservation): ReservationViewDTO
        {
            return new ReservationViewDTO(
                id: (int) $reservation->id,
                salleNom: (string) ($reservation->salle->nom ?? 'Inconnue'),
                responsable: (string) $reservation->responsable,
                email: (string) ($reservation->email ?? ''),
                motif: (string) ($reservation->motif ?? ''),
                dateDebut: (string) $reservation->date_debut,
                dateFin: (string) $reservation->date_fin,
                statut: (string) ($reservation->statut ?? 'confirmée')
            );
        }

        public static function fromEntities(iterable $reservations): Collection
        {
            return collect($reservations)->map(
                fn(Reservation $r) => self::fromEntity($r)
            );
        }
    }