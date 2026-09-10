<?php
    declare(strict_types=1);

    namespace App\Repository;

    use App\Model\Salle;
    use App\DTO\CreerSalleDTO;
    use Illuminate\Database\Eloquent\Collection;

    interface SalleRepositoryInterface
    {
        public function listerSalles(): Collection;


        public function retrouverSalleParId(int $id): ?Salle;

        public function enregistrerSalle(CreerSalleDTO $dto): Salle;
    }