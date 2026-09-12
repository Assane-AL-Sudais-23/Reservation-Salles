<?php
    declare(strict_types=1);

        namespace App\Repository;

        use App\Model\User;

        interface UserRepositoryInterface {
            public function retrouverParEmail(string $email): ?User;

            public function retrouverParId(int $id): ?User;
        }