<?php
declare(strict_types=1);

    namespace App\Validator;

    class ValidationResult
    {

        public function __construct(
            private readonly bool $isValid,
            private readonly array $errors = [],
            private readonly array $data = []
        ) {
        }

        public function isValid(): bool
        {
            return $this->isValid;
        }

        
        public function errors(): array
        {
            return $this->errors;
        }

        
        public function data(): array
        {
            return $this->data;
        }
    }