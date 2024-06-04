<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;

class UpdateBookTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $testData;

    protected function setUp(): void
    {
        parent::setUp();
        $this->testData = new TestData($this->faker);
    }

    public function test_update_book()
    {
        $headers = $this->testData->authenticate();

        $book = Book::factory()->create();

        $updatedData = [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
            'publication_year' => 2021,
        ];

        $response = $this->put("/api/books/{$book->id}", $updatedData, $headers);

        $response->assertStatus(200)
                 ->assertJsonFragment($updatedData);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => $updatedData['title'],
            'author' => $updatedData['author'],
            'publication_year' => $updatedData['publication_year'],
        ]);
    }

    public function test_update_nonexistent_book()
    {
        $headers = $this->testData->authenticate();
        $updatedData = [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
            'publication_year' => 2021,
        ];

        $response = $this->put('/api/books/999', $updatedData, $headers);
        $response->assertStatus(404);

        $expectedError = trans('exceptions.Book not found');
        $response->assertJsonFragment($expectedError);
    }

    public function test_unauthenticated_user_cannot_update_book()
    {

        $book = Book::factory()->create();
        $updatedData = [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
            'publication_year' => 2021,
        ];

        $response = $this->put("/api/books/{$book->id}", $updatedData);

        $response->assertStatus(401);
    }

    public function test_update_book_with_invalid_data()
    {
        $headers = $this->testData->authenticate();

        $book = Book::factory()->create();

        $updatedData = [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
            'publication_year' => 'invalid-year',
        ];

        $response = $this->put("/api/books/{$book->id}", $updatedData, $headers);

        $response->assertStatus(422);
        $expectedError = trans('exceptions.The publication year must be an integer.');
        $response->assertJsonFragment($expectedError);
    }

    public function test_update_book_with_missing_title()
    {
        $headers = $this->testData->authenticate();

        $book = Book::factory()->create();

        $updatedData = [
            'title' => '',
            'author' => 'Updated Author',
            'publication_year' => 2021,
        ];

        $response = $this->put("/api/books/{$book->id}", $updatedData, $headers);
        $response->assertStatus(422);


        $expectedError = trans('exceptions.The title field is required.');
        $response->assertJsonFragment($expectedError);
    }
    public function test_update_book_with_long_title()
    {
        $headers = $this->testData->authenticate();

        $book = Book::factory()->create();

        $updatedData = [
            'title' => str_repeat('A', 256),
            'author' => 'Updated Author',
            'publication_year' => 2021,
        ];

        $response = $this->put("/api/books/{$book->id}", $updatedData, $headers);

        $response->assertStatus(422);

        $expectedError = trans('exceptions.The title may not be greater than 255 characters.');
        $response->assertJsonFragment($expectedError);
    }

    public function test_update_book_with_duplicate_title()
    {
        $headers = $this->testData->authenticate();

        $book1 = Book::factory()->create(['title' => 'Existing Title']);
        $book2 = Book::factory()->create();
        

        $updatedData = [
            'title' => 'Existing Title',
            'author' => 'Updated Author',
            'publication_year' => 2021,
        ];

        $response = $this->put("/api/books/{$book2->id}", $updatedData, $headers);

        $response->assertStatus(200)
                 ->assertJsonFragment($updatedData);

    }

    public function test_update_book_with_missing_author()
    {
        $headers = $this->testData->authenticate();

        $book = Book::factory()->create();

        $updatedData = [
            'title' => 'Updated Title',
            'author' => '',
            'publication_year' => 2021,
        ];

        $response = $this->put("/api/books/{$book->id}", $updatedData, $headers);

        $response->assertStatus(422);

        $expectedError = trans('exceptions.The author field is required.');
        $response->assertJsonFragment($expectedError);
    }

    public function test_update_book_with_long_author()
    {
        $headers = $this->testData->authenticate();

        $book = Book::factory()->create();

        $updatedData = [
            'title' => 'Updated Title',
            'author' => str_repeat('A', 256),
            'publication_year' => 2021,
        ];

        $response = $this->put("/api/books/{$book->id}", $updatedData, $headers);

        $response->assertStatus(422);

        $expectedError = trans('exceptions.The author may not be greater than 255 characters.');
        $response->assertJsonFragment($expectedError);

     
    }

    public function test_update_book_with_invalid_publication_year_range()
    {
        $headers = $this->testData->authenticate();

        $book = Book::factory()->create();

        $updatedData = [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
            'publication_year' => -1,
        ];

   
        $response = $this->put("/api/books/{$book->id}", $updatedData, $headers);

        $response->assertStatus(422);

        $expectedError = trans('exceptions.The publication year must be between 0 and the current year.');
        $response->assertJsonFragment($expectedError);
    }
}
