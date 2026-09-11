<?php

declare(strict_types=1);

namespace App\Exception;

use Throwable;

class RegleMetierException extends ApplicationException
{
    public function __construct(
        string $message = 'La règle métier ne permet pas cette opération.',
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, 422, $code, $previous);
    }
}
