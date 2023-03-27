<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\AuthInterface;
use App\Services\Auth\AuthService;
use OpenApi\Annotations as OA;

class AuthController extends Controller {
    public function __construct(private AuthInterface $auth) {
    }

    /**
     * @OA\Post(
     *     path="/admin/login",
     *     description="Admin login",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"email", "password"},
     *            @OA\Property(property="email", type="email", format="string", example="admin@email.com"),
     *            @OA\Property(property="password", type="password", format="string", example="123456"),
     *         ),
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Logged in successfully",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Something went wrong",
     *      )
     * )
     */
    public function adminLogin(LoginRequest $request) {
        return $this->auth->login_process($request);
    }

    /**
     * @OA\Get(
     *     path="/admin/logout",
     *     description="Logout as an admin",
     *     @OA\Response (
     *          response=200,
     *          description="Successfully logged out",
     *     ),
     *      @OA\Response (
     *          response=401,
     *          description="Unauthenticated",
     *     )
     * )
     */
    public function adminLogout() {
        return $this->auth->logged_out();
    }

    /**
     * @OA\Post(
     *     path="/user/login",
     *     description="User login",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"email", "password"},
     *            @OA\Property(property="email", type="email", format="string", example="user@email.com"),
     *            @OA\Property(property="password", type="password", format="string", example="123456"),
     *         ),
     *      ),
     *     @OA\Response(
     *          response="200",
     *          description="Logged in successfully",
     *       ),
     *      @OA\Response(
     *          response="400",
     *          description="Something went wrong",
     *      ),
     * )
     */
    public function userLogin(LoginRequest $request) {
        return $this->auth->login_process($request);
    }

    /**
     * @OA\Get(
     *     path="/user/logout",
     *     description="Logout as an user",
     *     @OA\Response (
     *          response="200",
     *          description="Successfully logged out",
     *     ),
     *     @OA\Response (
     *          response=401,
     *          description="Unauthenticated",
     *     )
     * )
     */
    public function userLogout() {
        return $this->auth->logged_out();
    }
}
