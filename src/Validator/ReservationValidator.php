<?php

declare(strict_types=1);

namespace App\Validator;

use Respect\Validation\Validator as v;
use Respect\Validation\Exceptions\NestedValidationException;

class ReservationValidator implements ValidatorInterface
{
    public function validate(array $data): ValidationResult
    {
        $errors = [];

        $rules = [
            'salle_id' => v::key('salle_id', v::intVal()->positive()),
            'responsable' => v::key('responsable', v::stringType()->length(2, 120)),
            'email' => v::key('email', v::email()),
            'motif' => v::key('motif', v::stringType()->length(5, 255)),
            'date_debut' => v::key('date_debut', v::dateTime()),
            'date_fin' => v::key('date_fin', v::dateTime()),
        ];

        foreach ($rules as $field => $rule) {
            try {
                $rule->assert($data);
            } catch (NestedValidationException $exception) {
                $errors[$field] = sprintf("Le champ '%s' est invalide ou manquant.", $field);
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