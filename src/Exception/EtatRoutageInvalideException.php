<?php

declare(strict_types=1);

namespace App\Exception;

final class EtatRoutageInvalideException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct('État de routage invalide.');
    }
}
