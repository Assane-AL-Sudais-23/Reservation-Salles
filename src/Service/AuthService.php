<?php
    declare(strict_types=1);

    namespace App\Security;

    use App\Model\User;
    use App\Repository\UserRepositoryInterface;

    
    class AuthService
    {
        public function __construct(
            private readonly UserRepositoryInterface $userRepository
        ) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
        }

        public function tenterConnexion(string $email, string $motDePasse): bool
        {
            $user = $this->userRepository->retrouverParEmail($email);

            if ($user === null || !password_verify($motDePasse, $user->password)) {
                return false;
            }

            $_SESSION['user_id'] = $user->id;

            return true;
        }

        public function deconnecter(): void
        {
            unset($_SESSION['user_id']);
            session_regenerate_id(true);
        }

        public function estConnecte(): bool
        {
            return isset($_SESSION['user_id']);
        }

        public function utilisateurConnecte(): ?User
        {
            $id = $_SESSION['user_id'] ?? null;

            if ($id === null) {
                return null;
            }

            return $this->userRepository->retrouverParId((int) $id);
        }

        public function role(): ?Role
        {
            return $this->utilisateurConnecte()?->role;
        }
    }