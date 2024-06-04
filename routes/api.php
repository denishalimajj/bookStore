<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BookController;

// Route to get the authenticated user
Route::middleware('jwt.auth')->get('/user', function (Request $request) {
    return $request->user();
});

// USER ROUTES
Route::post('/register', [RegisterController::class, 'register']);

// LOGIN ROUTES
Route::post('/login', [LoginController::class, 'login']);

// BOOKS ROUTES
Route::middleware('jwt.auth')->group(function () {
    Route::post('/books', [BookController::class, 'addBooks']);
    Route::get('/books/{id}', [BookController::class, 'getBooksByID']);
    Route::put('/books/{id}', [BookController::class, 'updateBook']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);
});
Route::get('/books', [BookController::class, 'getAllBooks']);

