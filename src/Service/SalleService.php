<?php 
    declare(strict_types=1);

    namespace App\Service;

    use App\Model\Salle;
    use App\DTO\CreerSalleDTO;
    use Illuminate\Support\Collection;
    use App\Repository\SalleRepositoryInterface;
    use  App\DTO\SalleDTOBuilder;


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
            $sallesEntites = $this->salleRepository->listerSalles();
            return SalleDTOBuilder::fromEntities($sallesEntites);
        }

        public function enregistrerSalle(CreerSalleDTO $dto): Salle
        {
            $salle = new Salle();
            $this->hydraterSalle($salle, $dto);

            return $this->salleRepository->enregistrerSalle($salle);
        }

        public function mettreAJourSalle(int $id, CreerSalleDTO $dto): ?Salle
        {
            $salle = $this->salleRepository->retrouverSalleParId($id);

            if ($salle === null) {
                return null;
            }

            $this->hydraterSalle($salle, $dto);

            return $this->salleRepository->enregistrerSalle($salle);
        }

        private function hydraterSalle(Salle $salle, CreerSalleDTO $dto): void
        {
            $salle->nom = $dto->nom;
            $salle->batiment = $dto->batiment;
            $salle->capacite = $dto->capacite;
            $salle->type = $dto->type;
            $salle->active = $dto->active;
        }
    }