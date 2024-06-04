<?php

namespace App\Services;

use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Book;
use App\Http\Requests\CheckBookExistsRequest;



class BookService
{
    public function createBook($data)
    {
        return Book::create($data);
    }

    public function deleteBook($id)
    {
        $book  = Book::findOrFail($id);
        $book->delete();
    }

    public function getBookById($id)
    {
        return Book::find($id);
    }

    public function getAllBooks()
    {
        return Book::orderBy('id')->get();
    }

    public function bookExists($id)
    {
        return Book::where('id', $id)->exists();
    }
    public function updateBook($id, array $data)
{
    $book = Book::findOrFail($id);
    $book->update($data);
    return $book;
}


public function checkIfBookExists($bookId)
    {
        if (!Book::find($bookId)) {
            $response = response()->json([
                'code' => 40401,
                'message' => 'The specified book does not exist.',
                'description' => 'No query results for the specified book.',
            ], 404);

            throw new HttpResponseException($response);
        }
    }

}
