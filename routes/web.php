<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\DisableCsrf;
use Modules\User\Exceptions\UserException;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/api/documentation', function () {
    return view('swagger-ui');
});



Route::get('docs/exceptions/{code}', fn ($code) => $code)->name('docs.exceptions');