<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use OpenApi\Annotations as OA;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(private AuthService $auth_service) {
    }

    /**
     * @OA\Get(
     *     path="/api/login",
     *     @OA\Response(response="200", description="Login page")
     * )
     */
    public function login(LoginRequest $request) {
        return $this->auth_service->login_process($request);
    }

    public function profile() {
        $user = AuthService::authUser();
        if ($user['success'] == false) return errorResponse($user['message'],[],401);
        return successResponse(__('success'), $user['data']);
    }
}
