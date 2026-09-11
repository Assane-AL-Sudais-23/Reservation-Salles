<?php
declare(strict_types=1);

    namespace App\DTO;

    final class ReservationViewDTO
    {
        public function __construct(
            public readonly int $id,
            public readonly string $salleNom,
            public readonly string $responsable,
            public readonly string $email,
            public readonly string $motif,
            public readonly string $dateDebut,
            public readonly string $dateFin,
            public readonly string $statut
        ) {}
    }