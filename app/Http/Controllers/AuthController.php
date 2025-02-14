<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $service
    )
    {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $this->service->login($request->validated());
        return success($data);
    }

    public function loginWeb(Request $request)
    {
        return $this->service->loginWeb($request);
    }

    public function logout(): JsonResponse
    {
        $this->service->logout();
        return success();
    }
}
