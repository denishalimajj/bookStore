<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;

class GetAllBooksTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $testData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->testData = new TestData($this->faker);
    }

    public function test_get_all_books()
    {
        $headers = $this->testData->authenticate();
        $books = Book::factory()->count(3)->create();

        $response = $this->get('/api/books', $headers);

        $response->assertStatus(200)
                 ->assertJsonCount(3)
                 ->assertJsonFragment([
                     'title' => $books[0]->title,
                     'author' => $books[0]->author,
                     'publication_year' => (int) $books[0]->publication_year,
                 ])
                 ->assertJsonFragment([
                     'title' => $books[1]->title,
                     'author' => $books[1]->author,
                     'publication_year' => (int) $books[1]->publication_year,
                 ])
                 ->assertJsonFragment([
                     'title' => $books[2]->title,
                     'author' => $books[2]->author,
                     'publication_year' => (int) $books[2]->publication_year,
                 ]);
    }

    public function test_get_all_books_when_none_exist()
    {
        $headers = $this->testData->authenticate();

        $response = $this->get('/api/books', $headers);

        $response->assertStatus(200)
                 ->assertJsonCount(0);
    }

    public function test_unauthenticated_user_can_get_books()
    {
        $response = $this->get('/api/books');

        $response->assertStatus(200);
    }
}
