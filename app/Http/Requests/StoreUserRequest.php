<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pseudo' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'sometimes', 'required', ' confirmed', Password::min(8)->mixedCase()->letters()->numbers()->symbols()
            ],
        ];
    }

    public function messages()
    {
        return [
            'pseudo.required' => 'Le pseudo est obligatoire.',
            'pseudo.string' => 'Le pseudo doit être une chaîne de caractères.',
            'pseudo.max' => 'Le pseudo ne peut pas dépasser 255 caractères.',
            'pseudo.unique' => 'Ce pseudo est déjà utilisé.',
            'email.required' => 'L’adresse e-mail est obligatoire.',
            'email.string' => 'L’adresse e-mail doit être une chaîne de caractères.',
            'email.email' => 'L’adresse e-mail n’est pas valide.',
            'email.max' => 'L’adresse e-mail ne peut pas dépasser 255 caractères.',
            'email.unique' => 'Cette adresse e-mail est déjà utilisée.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.string' => 'Le mot de passe doit être une chaîne de caractères.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'role_id.required' => 'Le rôle est obligatoire.',
            'role_id.exists' => 'Le rôle sélectionné n’est pas valide.',
            'image.image' => 'Le fichier doit être une image.',
        ];
    }
}
