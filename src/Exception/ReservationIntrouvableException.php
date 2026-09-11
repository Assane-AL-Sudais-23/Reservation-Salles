<?php

declare(strict_types=1);

namespace App\Exception;

use Throwable;

class ReservationIntrouvableException extends ApplicationException
{
    public function __construct(
        string $message = 'La réservation demandée est introuvable.',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, 404, $code, $previous);
    }
}
