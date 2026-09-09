<?php

    declare(strict_types=1);

    namespace App\Validator;

    use Respect\Validation\Validator as v;
    use Respect\Validation\Exceptions\NestedValidationException;

    class SalleValidator implements ValidatorInterface
    {

        private const ALLOWED_TYPES = ['amphi', 'tp', 'reunion', 'standard'];

        public function validate(array $data): ValidationResult
        {
            $errors = [];

            $rules = [
                'nom' => v::key('nom', v::stringType()->length(2, 100)),
                'batiment' => v::key('batiment', v::stringType()->length(2, 100)),
                'capacite' => v::key('capacite', v::intVal()->between(1, 1000)),
                'type' => v::key('type', v::stringType()->in(self::ALLOWED_TYPES)),
                'active' => v::key('active', v::boolType()),
            ];

            foreach ($rules as $field => $rule) {
                try {
                    $rule->assert($data);
                } catch (NestedValidationException $exception) {
                    $errors[$field] = sprintf("Le champ '%s' est invalide.", $field);
                }
            }

            $isValid = count($errors) === 0;

            return new ValidationResult(
                isValid: $isValid,
                errors: $errors,
                data: $isValid ? $data : []
            );
        }
    }