<?php

namespace Tests\Feature;

use Faker\Generator as Faker;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class TestData
{
    public $userData;
    public $uniqueEmailUserData;
    public $loginData;
    public $headers;

    public function __construct(Faker $faker)
    {
        $this->userData = [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $this->uniqueEmailUserData = [
            'name' => 'John Doe',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $this->loginData = [
            'email' => 'john12@example.com',
            'password' => 'password'
        ];
    }

    public function authenticate()
    {
        $user = User::create([
            'name' => $this->userData['name'],
            'email' => $this->userData['email'],
            'password' => bcrypt($this->userData['password']),
        ]);

        $token = JWTAuth::fromUser($user);

        $this->headers = ['Authorization' => "Bearer $token"];

        return $this->headers;
    }
}
