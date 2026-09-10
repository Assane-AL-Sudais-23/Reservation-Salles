<?php
    declare(strict_types=1);

    namespace App\Service;

    use App\Repository\SalleRepositoryInterface;
    use Illuminate\Database\Eloquent\Collection;

    final class ListerSallesService
    {
        public function __construct(
            private readonly SalleRepositoryInterface $salleRepository
        ) {
        }

        public function executer(): Collection
        {
            return $this->salleRepository->listerSalles();
        }
    }