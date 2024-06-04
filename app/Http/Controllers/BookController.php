<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Services\BookService;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Http\JsonResponse;

class BookController extends BaseController
{
    use ValidatesRequests;

    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function addBooks(StoreBookRequest $request)
    {
            $data = $request->validated(); 

            $book = $this->bookService->createBook($data);
            return (new BookResource($book))
                        ->response()
                        ->setStatusCode(Response::HTTP_CREATED);
        
    }

    public function destroy($id)
        {
         $this->bookService->checkIfBookExists($id);
         $this->bookService->deleteBook($id);

         return response(null,Response::HTTP_NO_CONTENT);
    
    }
    public function getBooksByID($id)
    {
            $this->bookService->checkIfBookExists($id);
            $book = $this->bookService->getBookById($id);

            return (new BookResource($book))
                ->response()
                ->setStatusCode(Response::HTTP_OK);
        
    }
    public function getAllBooks()
    {
            $books = $this->bookService->getAllBooks();
            return BookResource::collection($books)
                        ->response()
                        ->setStatusCode(Response::HTTP_OK);
        
    }

    public function updateBook(UpdateBookRequest $request, $id)
    {
            $this->bookService->checkIfBookExists($id);
            $data = $request->validated();
            $book = $this->bookService->updateBook($id, $data);
            return (new BookResource($book))
                        ->response()
                        ->setStatusCode(Response::HTTP_OK);
    }
    
}
