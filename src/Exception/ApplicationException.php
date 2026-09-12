<?php

declare(strict_types=1);

namespace App\Exception;

use RuntimeException;
use Throwable;

abstract class ApplicationException extends RuntimeException
{
    public function __construct(
        string $message,
        private readonly int $statusCode = 500,
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
