<?php

namespace Tests\Unit;

use App\Models\Book;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    use RefreshDatabase; 

    public function testBookTitle()
    {
        $book = new Book(['title' => '1984']);
        $this->assertEquals('1984', $book->title);
    }

    public function testBookAuthor()
    {
        $book = new Book(['author' => 'George Orwell']);
        $this->assertEquals('George Orwell', $book->author);
    }

    public function testBookPublicationYear()
    {
        $book = new Book(['publication_year' => 1949]);
        $this->assertEquals(1949, $book->publication_year);
    }

    public function testFillableAttributes()
    {
        $book = new Book();
        $fillable = $book->getFillable();
        $this->assertContains('title', $fillable);
        $this->assertContains('author', $fillable);
        $this->assertContains('publication_year', $fillable);
    }

    public function testTimestampsDisabled()
    {
        $book = new Book();
        $this->assertFalse($book->timestamps);
    }

    public function testMassAssignmentProtection()
    {
        $book = new Book(['id' => 1, 'title' => '1984', 'author' => 'George Orwell']);
        $this->assertNull($book->id); 
        $this->assertEquals('1984', $book->title);
        $this->assertEquals('George Orwell', $book->author);
    }
}