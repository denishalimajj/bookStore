<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;

class GetBookTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $testData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->testData = new TestData($this->faker);
    }

    public function test_get_book_by_id()
    {
        $headers = $this->testData->authenticate();
        $book = Book::create([
            'title' => $this->faker->sentence,
            'author' => $this->faker->name,
            'publication_year' => $this->faker->year,
        ]);
        
        $response = $this->get("/api/books/{$book->id}", $headers);

        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'id' => $book->id,
                     'title' => $book->title,
                     'author' => $book->author,
                     'publication_year' => (int) $book->publication_year,
                 ]);
    }

    public function test_get_nonexistent_book_by_id()
    {
        $headers = $this->testData->authenticate();

        // Attempt to get a book that does not exist
        $response = $this->get('/api/books/999', $headers);

        $response->assertStatus(404);

        $expectedError = trans('exceptions.Book not found');

        // Assert that the response contains the error message
        $response->assertJsonFragment($expectedError);
    }

    public function test_unauthenticated_user_cannot_get_book_by_id()
    {
        // Create a book
        $book = Book::create([
            'title' => $this->faker->sentence,
            'author' => $this->faker->name,
            'publication_year' => $this->faker->year,
        ]);

        // Attempt to get the book by ID without authentication
        $response = $this->get("/api/books/{$book->id}");

        $response->assertStatus(401);
    }
}
