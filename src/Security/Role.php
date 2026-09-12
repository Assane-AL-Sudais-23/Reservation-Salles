<?php
    declare(strict_types=1);

    namespace App\Security;

    enum Role: string {
        case ADMIN = 'admin';
        case RESPONSABLE = 'responsable';

        public function libelle(): string
        {
            return match ($this) {
                self::ADMIN => 'Administrateur',
                self::RESPONSABLE => 'Responsable',
            };
        }
    }