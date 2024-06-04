<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\HandlesValidationErrors;

class LoginRequest extends FormRequest
{
    use HandlesValidationErrors;
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email is required',
            'email.email' => 'Invalid email format',
            'password.required' => 'The password field is required.',
            'password.string' => 'Password must be a string',
            'password.min' => 'The password must be at least 8 characters.',
        ];
    }


}
