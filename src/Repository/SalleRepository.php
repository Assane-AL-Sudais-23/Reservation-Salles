<?php
    declare(strict_types=1);

    namespace App\Repository;

    use App\Model\Salle;
    use App\Repository\SalleRepositoryInterface;
    use Illuminate\Database\Eloquent\Collection;

    class SalleRepository implements SalleRepositoryInterface
    {
        public function listerSalles(): Collection
        {
            return Salle::all();
        }

        public function retrouverSalleParId(int $id): ?Salle
        {
            return Salle::find($id);
        }

        public function enregistrerSalle(Salle $salle): Salle
        {
            return Salle::create($salle->build());
        }

    }