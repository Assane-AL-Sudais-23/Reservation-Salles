<?php

    declare(strict_types=1);

    namespace Tests\Units\Doubles;

    use App\Model\Salle;
    use App\Repository\SalleRepositoryInterface;
    use Illuminate\Database\Eloquent\Collection;

    class InMemorySalleRepository implements SalleRepositoryInterface
    {
        private array $salles = [];

        public function listerSalles(): Collection
        {
            return new Collection(array_values($this->salles));
        }

        public function retrouverSalleParId(int $id): ?Salle
        {
            return $this->salles[$id] ?? null;
        }

        public function enregistrerSalle(Salle $salle): Salle
        {
            if ($salle->id === null) {
                $id = count($this->salles) + 1;
                $salle->id = $id;
            }

            $this->salles[$salle->id] = $salle;

            return $salle;
        }
    }