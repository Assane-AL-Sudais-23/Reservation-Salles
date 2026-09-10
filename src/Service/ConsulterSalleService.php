<?php
    declare(strict_types=1);

    namespace App\Service;

    use App\Model\Salle;
    use App\Repository\SalleRepositoryInterface;

    final class ConsulterSalleService
    {
        public function __construct(
            private readonly SalleRepositoryInterface $salleRepository
        ) {
        }

        public function executer(int $id): ?Salle
        {
            return $this->salleRepository->retrouverSalleParId($id);
        }
    }