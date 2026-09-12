<?php
    declare(strict_types=1);

    namespace App\Validator;

    use Respect\Validation\Validator as v;
    use Respect\Validation\Exceptions\NestedValidationException;

    class AuthValidator implements ValidatorInterface
    {
        public function validate(array $data): ValidationResult
        {
            $errors = [];

            $rules = [
                'email' => v::key('email', v::email()),
                'password' => v::key('password', v::stringType()->notEmpty()),
            ];

            foreach ($rules as $field => $rule) {
                try {
                    $rule->assert($data);
                } catch (NestedValidationException $exception) {
                    $errors[$field] = sprintf("Le champ '%s' est invalide.", $field);
                }
            }

            $isValid = empty($errors);

            return new ValidationResult(
                isValid: $isValid,
                errors: $errors,
                data: $isValid ? $data : []
            );
        }
    }