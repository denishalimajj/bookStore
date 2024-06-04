<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;

class DeleteBookTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $testData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->testData = new TestData($this->faker);
    }

    public function test_delete_book()
    {
        $headers = $this->testData->authenticate();
        $book = Book::create([
            'title' => $this->faker->sentence,
            'author' => $this->faker->name,
            'publication_year' => $this->faker->year,
        ]);
        $response = $this->delete("/api/books/{$book->id}", [], $headers);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    public function test_delete_nonexistent_book()
    {
        $headers = $this->testData->authenticate();
        $response = $this->delete('/api/books/999', [], $headers);

        $response->assertStatus(404);

        $expectedError = trans('exceptions.Book not found');
        $response->assertJsonFragment($expectedError);
    }

    public function test_unauthenticated_user_cannot_delete_book()
    {
        $book = Book::create([
            'title' => $this->faker->sentence,
            'author' => $this->faker->name,
            'publication_year' => $this->faker->year,
        ]);
        $response = $this->delete("/api/books/{$book->id}");

        $response->assertStatus(401);
    }
}
