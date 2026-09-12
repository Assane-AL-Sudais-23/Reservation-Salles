<?php
declare(strict_types=1);

    namespace App\Routing;

    use App\Security\Role;

   
    final class RouteDefinition
    {
        private function __construct(
            public readonly array $handler,
            private readonly bool $requiertAuthentification,
            private readonly array $rolesAutorises
        ) {
        }

        public static function publique(array $handler): self
        {
            return new self($handler, false, []);
        }

        public static function authentifiee(array $handler): self
        {
            return new self($handler, true, []);
        }

        public static function protegee(array $handler, Role ...$roles): self
        {
            return new self($handler, true, $roles);
        }

        public function estAutorisePour(?Role $role): bool
        {
            if (!$this->requiertAuthentification) {
                return true;
            }

            if ($role === null) {
                return false;
            }

            return empty($this->rolesAutorises) || in_array($role, $this->rolesAutorises, true);
        }

        public function requiertUneConnexion(): bool
        {
            return $this->requiertAuthentification;
        }
    }