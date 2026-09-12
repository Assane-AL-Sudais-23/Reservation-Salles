<?php
    declare(strict_types=1);

    namespace App\Repository;

    use App\Model\User;

    class UserRepository implements UserRepositoryInterface
    {
        public function retrouverParEmail(string $email): ?User
        {
            return User::where('email', $email)->first();
        }

        public function retrouverParId(int $id): ?User
        {
            return User::find($id);
        }
    }