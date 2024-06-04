<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use Tymon\JWTAuth\Facades\JWTAuth;

class CreateBookTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $userData;
    protected $bookData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
        ];
        $this->bookData = [
            'title' => $this->faker->sentence,
            'author' => $this->faker->name,
            'publication_year' => $this->faker->year,
        ];
    }

    protected function authenticate()
    {
        $user = User::create($this->userData);
        $token = JWTAuth::fromUser($user);

        return ['Authorization' => "Bearer $token"];
    }

    public function test_create_book()
    {
        $headers = $this->authenticate();

        $response = $this->post('/api/books', $this->bookData, $headers);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'title' => $this->bookData['title'],
                     'author' => $this->bookData['author'],
                     'publication_year' => $this->bookData['publication_year'],
                 ]);
    }

    public function test_create_book_with_missing_title()
    {
        $headers = $this->authenticate();

        $bookData = $this->bookData;
        $bookData['title'] = '';

        $response = $this->post('/api/books', $bookData, $headers);

        $response->assertStatus(422);

        $expectedError = trans('exceptions.The title field is required.');

        $response->assertJsonFragment($expectedError);
    }

    public function test_create_book_with_invalid_publicationYear()
    {
        $headers = $this->authenticate();

        $bookData = $this->bookData;
        $bookData['publication_year'] = 'invalid-publication_year';

        $response = $this->post('/api/books', $bookData, $headers);

        $response->assertStatus(422);

        $expectedError = trans('exceptions.The publication year must be an integer.');

        $response->assertJsonFragment($expectedError);
    }

    public function test_unauthenticated_user_cannot_create_book()
    {
        $response = $this->post('/api/books', $this->bookData);

        $response->assertStatus(401);
    }

    public function test_create_book_with_duplicate_title()
    {
        $headers = $this->authenticate();

        Book::create($this->bookData);

        $response = $this->post('/api/books', $this->bookData, $headers);

        $response->assertStatus(422);

        $expectedError = trans('exceptions.The title has already been taken.');

        $response->assertJsonFragment($expectedError);
    }
}
