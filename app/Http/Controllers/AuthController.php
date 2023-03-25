<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\AuthService;
use OpenApi\Annotations as OA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
    public function __construct(private AuthService $auth_service) {
    }

    /**
     * @OA\Get(
     *     path="/api/admin/login",
     *     description="Admin login",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/app/Helper/functions/successResponse")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Wrong operation",
     *          @OA\JsonContent(ref="#/app/Helper/functions/errorResponse")
     *      ),
     * )
     */
    public function adminLogin(LoginRequest $request) {
        return $this->auth_service->login_process($request);
    }

    /**
     * @OA\Get(
     *     path="/api/admin/logout",
     *     description="Logout as an admin"
     *     @OA\Response(
     *          response=200,
     *          description="Successful logged out operation as an admin",
     *          @OA\JsonContent(ref="#/app/Helper/functions/successResponse")
     *     )
     * )
     */
    public function adminLogout() {
        return $this->auth_service->logged_out();
    }

    /**
     * @OA\Get(
     *     path="/api/user/login",
     *     description="User login",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/app/Helper/functions/successResponse")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Wrong operation",
     *          @OA\JsonContent(ref="#/app/Helper/functions/errorResponse")
     *      ),
     * )
     */
    public function userLogin(LoginRequest $request) {
        return $this->auth_service->login_process($request);
    }

    /**
     * @OA\Get(
     *     path="/api/user/logout",
     *     description="Logout as an user"
     *     @OA\Response(
     *          response=200,
     *          description="Successful logged out operation as an user",
     *          @OA\JsonContent(ref="#/app/Helper/functions/successResponse")
     *     )
     *)
     */
    public function userLogout() {
        return $this->auth_service->logged_out();
    }
}
