<?php

    declare(strict_types=1);

    namespace App\DTO;


    class CreerReservationDTO
    {
        public function __construct(
            public readonly int $salleId,
            public readonly string $responsable,
            public readonly string $email,
            public readonly string $motif,
            public readonly \DateTimeImmutable $dateDebut,
            public readonly \DateTimeImmutable $dateFin
        ) {
        }

        public static function fromArray(array $data): self
        {
            return new self(
                salleId: (int) $data['salle_id'],
                responsable: (string) $data['responsable'],
                email: (string) $data['email'],
                motif: (string) $data['motif'],
                dateDebut: new \DateTimeImmutable($data['date_debut']),
                dateFin: new \DateTimeImmutable($data['date_fin'])
            );
        }

        public function toArray(): array
        {
            return [
                'salle_id' => $this->salleId,
                'responsable' => $this->responsable,
                'email' => $this->email,
                'motif' => $this->motif,
                'date_debut' => $this->dateDebut->format('Y-m-d H:i:s'),
                'date_fin' => $this->dateFin->format('Y-m-d H:i:s'),
            ];
        }
    }