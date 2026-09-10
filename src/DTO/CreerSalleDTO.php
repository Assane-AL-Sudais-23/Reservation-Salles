<?php
declare(strict_types=1);

    namespace App\DTO;

    class CreerSalleDTO
    {
        public function __construct(
            public readonly string $nom,
            public readonly string $batiment,
            public readonly int $capacite,
            public readonly string $type,
            public readonly bool $active = true
        ) {
        }


        public static function fromArray(array $data): self
        {
            return new self(
                nom: (string) $data['nom'],
                batiment: (string) $data['batiment'],
                capacite: (int) $data['capacite'],
                type: (string) $data['type'],
                active: isset($data['active']) ? (bool) $data['active'] : true
            );
        }

        public function toArray(): array
        {
            return [
                'nom' => $this->nom,
                'batiment' => $this->batiment,
                'capacite' => $this->capacite,
                'type' => $this->type,
                'active' => $this->active,
            ];
        }
    }