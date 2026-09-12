<?php
    declare(strict_types=1);

    namespace App\Exception;

    use Throwable;

        abstract class ExceptionMetier extends ApplicationException
    {
            public function __construct(
                string $message,
                int $statusCode = 422,
                int $code = 0,
                ?Throwable $previous = null
            ) {
                parent::__construct($message, $statusCode, $code, $previous);
            }
    }
