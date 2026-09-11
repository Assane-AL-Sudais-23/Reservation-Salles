<?php
    declare(strict_types=1);

    namespace App\DTO;

    final class SalleViewDTO
    {
        public function __construct(
            public readonly int $id,
            public readonly string $nom,
            public readonly string $batiment,
            public readonly int $capacite,
            public readonly string $type,
            public readonly bool $active = true
        ) {}
    }