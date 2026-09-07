<?php

namespace App\Validation;

use Respect\Validation\Validator as v;

class ReservationValidator implements ValidatorInterface
{
    public function validate(array $data): ValidationResult
    {
        $errors = [];

        $rules = [
            'salle_id' => v::intType()->positive(),
            'responsable' => v::stringType()->notEmpty()->length(2, 120),
            'email' => v::email(),
            'motif' => v::stringType()->notEmpty()->length(5, 255),
            'date_debut' => v::dateTime('Y-m-d H:i:s'),
            'date_fin' => v::dateTime('Y-m-d H:i:s')
        ];

        $messages = [
            'salle_id' => 'L\'identifiant de la salle doit être un entier positif.',
            'responsable' => 'Le responsable est obligatoire et doit contenir entre 2 et 120 caractères.',
            'email' => 'L\'adresse email est invalide.',
            'motif' => 'Le motif est obligatoire et doit contenir entre 5 et 255 caractères.',
            'date_debut' => 'La date de début est invalide.',
            'date_fin' => 'La date de fin est invalide.'
        ];

        foreach ($rules as $field => $validator) {
            $value = $data[$field] ?? null;

            if (!$validator->validate($value)) {
                $errors[$field][] = $messages[$field];
            }
        }

        return new ValidationResult( empty($errors), $errors, $data );
    }
}