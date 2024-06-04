<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use App\Services\LoginService;
use App\Http\Resources\LoginResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Response;
use Exception;

class LoginController extends Controller
{
    protected $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function login(LoginRequest $request): JsonResponse
    { 
        try {
            $data = $request->all();

            $result = $this->loginService->authenticate($data);
            $user = $result['user'];
            $token = $result['token'];

            return response()->json([
                'token' => $token,
                'user' => new LoginResponse($user),
            ], Response::HTTP_OK);
    }catch (ValidationException $e) {
        $errorDetails = Lang::get('exceptions.Invalid credentials');
        return response()->json($errorDetails, 500);
    }
}
}


