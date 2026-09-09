<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\ReservationRepositoryInterface;
use App\Exception\ReservationIntrouvableException;

class AnnulerReservationService
{
    public function __construct(
        private readonly ReservationRepositoryInterface $reservationRepository
    ) {
    }


    public function executer(int $reservationId): bool
    {
        $reservation = $this->reservationRepository->retrouverReservationParId($reservationId);

        if (!$reservation) {
            throw new ReservationIntrouvableException("La réservation #{$reservationId} est introuvable.");
        }

        return $this->reservationRepository->annulerReservation($reservationId);
    }
}