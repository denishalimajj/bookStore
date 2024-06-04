<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Traits\HandlesValidationErrors;

class RegisterRequest extends FormRequest
{
    use HandlesValidationErrors;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Username cannot be empty',
            'name.string' => 'Username must be a string',
            'name.max' => 'The name may not be greater than 255 characters.',
            'email.required' => 'Email is required',
            'email.email' => 'Invalid email format',
            'email.unique' => 'User already exists',
            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }

}
