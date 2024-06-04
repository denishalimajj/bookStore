<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserLoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $testData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->testData = new TestData($this->faker);
    }

    public function test_successful_login()
    {
        $user = User::create([
            'name' => $this->testData->userData['name'],
            'email' => $this->testData->loginData['email'],
            'password' => bcrypt($this->testData->loginData['password'])
        ]);

        $response = $this->post('/api/login', $this->testData->loginData);
        $response->assertStatus(200);
    }

    public function test_login_with_incorrect_password()
    {
        $user = User::create([
            'name' => $this->testData->userData['name'],
            'email' => $this->testData->loginData['email'],
            'password' => bcrypt($this->testData->loginData['password'])
        ]);
        $loginData = $this->testData->loginData;
        $loginData['password'] = 'wrongpassword';

        $response = $this->post('/api/login', $loginData);

        $response->assertStatus(500);


    }

    public function test_login_with_nonexistent_email()
    {
        $loginData = $this->testData->loginData;
        $loginData['email'] = 'nonexistent@example.com';

        $response = $this->post('/api/login', $loginData);

        $response->assertStatus(500);
    }

    public function test_empty_email_field_validation()
    {
        $loginData = $this->testData->loginData;
        $loginData['email'] = '';

        $response = $this->post('/api/login', $loginData);

        $response->assertStatus(422);

        $expectedError = trans('exceptions.Email is required');

        $response->assertJsonFragment($expectedError);
    }

    public function test_empty_password_field_validation()
    {
        $loginData = $this->testData->loginData;
        $loginData['password'] = '';

        $response = $this->post('/api/login', $loginData);

        $response->assertStatus(422);

        $expectedError = trans('exceptions.The password field is required.');

        $response->assertJsonFragment($expectedError);
    }
}
