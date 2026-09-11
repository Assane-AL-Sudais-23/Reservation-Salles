<?php 
    declare(strict_types=1);

    namespace App\Service;

    use App\Model\Salle;
    use App\DTO\CreerSalleDTO;
    use Illuminate\Database\Eloquent\Collection;
    use App\Repository\SalleRepositoryInterface;


    class SalleService {

        public function __construct(
            private readonly SalleRepositoryInterface $salleRepository
        ) {
        }

        public function retrouverSalle(int $id): ?Salle
        {
            return $this->salleRepository->retrouverSalleParId($id);
        }

        public function listeSalles(): Collection
        {
            return $this->salleRepository->listerSalles();
        }

        public function enregistrerSalle(CreerSalleDTO $dto): Salle
        {
            $salle = new Salle();

            $salle->nom = $dto->nom;
            $salle->batiment = $dto->batiment;
            $salle->capacite = $dto->capacite;
            $salle->type = $dto->type;
            $salle->active = $dto->active;

            return $this->salleRepository->enregistrerSalle($salle);
        }
    }