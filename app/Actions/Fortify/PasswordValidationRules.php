<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Rules\Password;

// Permet les exigences de mot de passe :

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function passwordRules()
    {
        // Require at least one special character...
        //(new Password)->requireSpecialCharacter()
        return ['required', 'string', new Password, 'confirmed'];
    }
}
