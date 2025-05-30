<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules for passwords.
     *
     * @return array
     */
    protected function passwordRules(): array
    {
        return [
            'required',
            'string',
            'min:8',
            'regex:/^(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*()\-_=+{};:,<.>])/',
            'confirmed'
        ];
    }

    /**
     * Get the error messages for password validation.
     *
     * @return array
     */
    protected function passwordMessages(): array
    {
        return [
            'password.regex' => 'La contraseña debe contener al menos una mayúscula, un número y un carácter especial.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ];
    }
} 