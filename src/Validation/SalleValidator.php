<?php

namespace App\Validation;
use App\Validation\ValidationResult;

use Respect\Validation\Validator as v;

class SalleValidator implements ValidatorInterface
{
   
    public function validate(array $data): ValidationResult
    {

        $errors = [];

        $rules = [
            'nom' => v::stringType()->notEmpty()->length(2, 100),
            'batiment' => v::stringType()->notEmpty()->length(2, 100),
            'capacite' => v::intType()->between(1, 1000),
            'type' => v::in([
                'cours',
                'informatique',
                'laboratoire',
                'amphitheatre',
                'reunion'
            ]),
            'active' => v::boolType()
        ];

        $messages = [
            'nom' => 'Le nom est obligatoire et doit contenir entre 2 et 100 caractères.',
            'batiment' => 'Le bâtiment est obligatoire et doit contenir entre 2 et 100 caractères.',
            'capacite' => 'La capacité doit être un entier compris entre 1 et 1000.',
            'type' => 'Le type de salle n\'est pas autorisé.',
            'active' => 'Le champ active doit être un booléen.'
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




































 // public function validate(array $data): ValidationResult
    // {
    //     $errors = [];


    //     $nom = $data['nom'] ?? null;
    //     $nomValidator = v::stringType()->notEmpty()->length(2, 100);
    //     if (!$nomValidator->validate($nom)) {
    //         $errors['nom'][] = 'Le nom est obligatoire et doit contenir entre 2 et 100 caractères.';
    //     }

    //     $batiment = $data['batiment'] ?? null;
    //     $batimentValidator = v::stringType()->notEmpty()->length(2,100);
    //     if (!$batimentValidator->validate($batiment)) {
    //         $errors['batiment'][] = 'Le bâtiment est obligatoire et doit contenir entre 2 et 100 caractères.';
    //     }

    //     $capacite = $data['capacite'] ?? null;
    //     $capaciteValidator = v::intType()->between(1,1000);
    //     if (!$capaciteValidator->validate($capacite)) {
    //         $errors['capacite'][] = 'La capacité doit être un entier compris entre 1 et 1000.';
    //     }

    //     $type = $data['type'] ?? null;
    //     $typeValidator = v::in(['cours', 'informatique', 'laboratoire', 'amphitheatre', 'reunion']);
    //     if (!$typeValidator->validate($type)) {
    //         $errors['type'][] = 'Le type de salle n\'est pas autorisé.';
    //     }

    //     $active = $data['active'] ?? null;
    //     $activeValidator = v::boolType();
    //     if (!$activeValidator->validate($active)) {
    //        $errors['active'][] = 'Le champ active doit être un booléen.';
    //     }


    //     return new ValidationResult(
    //         empty($errors), $errors , $data
    //     );

    // }

