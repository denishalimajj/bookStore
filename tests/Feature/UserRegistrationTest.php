<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserRegistrationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $testData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->testData = new TestData($this->faker);
    }

    public function test_user_registration()
    {
        $response = $this->post('/api/register', $this->testData->userData);

        $response->assertStatus(201); 
    }

    public function test_user_login()
    {
        $user = User::create([
            'name' => 'Test User 1', 
            'email' => $this->testData->loginData['email'],
            'password' => bcrypt($this->testData->loginData['password'])
        ]);

        $response = $this->post('/api/login', $this->testData->loginData);

        $response->assertStatus(200);
    }

    public function test_unique_email_validation()
    {
        User::factory()->create(['email' => $this->testData->uniqueEmailUserData['email']]);

        $response = $this->post('/api/register', $this->testData->uniqueEmailUserData);

        $response->assertStatus(422);

        $expectedError = trans('exceptions.User already exists');

        $response->assertJson($expectedError);
    }
    public function test_empty_name_field_validation()
    {
        $data = $this->testData->userData;
        $data['name'] = '';

        $response = $this->post('/api/register', $data);
        $response->assertStatus(422);

        $expectedError = trans('exceptions.Username cannot be empty');

        $response->assertJsonFragment($expectedError);
    }

    public function test_invalid_email_format_validation()
    {
        $data = $this->testData->userData;
        $data['email'] = 'invalid-email-format';

        $response = $this->post('/api/register', $data);
        $response->assertStatus(422);

        $expectedError = trans('exceptions.Invalid email format');

        $response->assertJsonFragment($expectedError);
    }
    public function test_empty_email_field_validation()
    {
        $data = $this->testData->userData;
        $data['email'] = '';

        $response = $this->post('/api/register', $data);
        $response->assertStatus(422);

        $expectedError = trans('exceptions.Email is required');

        $response->assertJsonFragment($expectedError);
    }
    public function test_name_field_validation()
    {
        $data = $this->testData->userData;
        $data['name'] = 12344;

        $response = $this->post('/api/register', $data);
        $response->assertStatus(422);

        $expectedError = trans('exceptions.Username must be a string');

        $response->assertJsonFragment($expectedError);
    }
    public function test_empty_password_field_validation()
    {
        $data = $this->testData->userData;
        $data['password'] = '';

        $response = $this->post('/api/register', $data);
        $response->assertStatus(422);

        $expectedError = trans('exceptions.The password field is required.');

        $response->assertJsonFragment($expectedError);
    }
    public function test_short_password_validation()
    {
        $data = $this->testData->userData;
        $data['password'] = 'short';
        $data['password_confirmation'] = 'short';

        $response = $this->post('/api/register', $data);
        $response->assertStatus(422);

        $expectedError = trans('exceptions.The password must be at least 8 characters.');

        $response->assertJsonFragment($expectedError);
    }

    public function test_password_confirmation_mismatch()
    {
        $data = $this->testData->userData;
        $data['password'] = 'password';
        $data['password_confirmation'] = 'different_password';

        $response = $this->post('/api/register', $data);
        $response->assertStatus(422);

        $expectedError = trans('exceptions.The password confirmation does not match.');

        $response->assertJsonFragment($expectedError);
    }
}
