<?php
    declare(strict_types=1);

    namespace App\DTO;

    use App\Model\Salle;
    use Illuminate\Support\Collection;

    final class SalleDTOBuilder
    {

        public static function fromEntity(Salle $salle): SalleViewDTO
        {
            return new SalleViewDTO(
                id: (int) $salle->id,
                nom: (string) $salle->nom,
                batiment: (string) ($salle->batiment ?? ''),
                capacite: (int) $salle->capacite,
                type: (string) ($salle->type ?? ''),
                active: (bool) ($salle->active ?? true)
            );
        }

        public static function fromEntities(iterable $salles): Collection
        {
            return collect($salles)->map(
                fn(Salle $salle) => self::fromEntity($salle)
            );
        }
    }