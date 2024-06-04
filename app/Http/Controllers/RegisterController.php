<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResponse;
use App\Services\RegisterService;
use Illuminate\Http\Response;

class RegisterController extends Controller
{
    protected $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();
        $user = $this->registerService->createUser($validatedData);

        return (new UserResponse($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
