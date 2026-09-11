<?php

declare(strict_types=1);

namespace App\Exception;

use Throwable;

class SalleIndisponibleException extends ApplicationException
{
    public function __construct(
        string $message = 'La salle demandée est indisponible.',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, 409, $code, $previous);
    }
}
