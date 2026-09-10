<?php
    declare(strict_types=1);

    namespace App\Service;

    use App\DTO\CreerSalleDTO;
    use App\Model\Salle;
    use App\Repository\SalleRepositoryInterface;

    final class CreerSalleService
    {
        public function __construct(
            private readonly SalleRepositoryInterface $salleRepository
        ) {
        }

        public function executer(CreerSalleDTO $dto): Salle
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