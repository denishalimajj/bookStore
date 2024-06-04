<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Lang;

class LoginService
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function authenticate(array $data)
    {
        $email = $data['email'];
        $password = $data['password'];

        $user = $this->validateCredentials($email, $password);

        if (!$token = JWTAuth::fromUser($user)) {
            throw ValidationException::withMessages(['credentials' => Lang::get('exceptions.Invalid credentials.message')]);
        }

        return ['token' => $token, 'user' => $user];
    }

    private function validateCredentials(string $email, string $password): User
    {
        $user = $this->user->where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages(['credentials' => Lang::get('exceptions.Invalid credentials.message')]);
        }
        return $user;
    }
}
