<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserProfileRequest;
use App\Services\Admin\User\AdminUserInterface;
use App\Services\Auth\AuthInterface;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class ProfileController extends Controller {
    public function __construct(private AdminUserInterface $auth) {
    }

    /**
     * @OA\Get(
     *     path="/user",
     *     description="Get auth user",
     *     @OA\Response (
     *          response=200,
     *          description="User info retrieved successfully",
     *     ),
     *     @OA\Response (
     *          response=400,
     *          description="Something went wrong",
     *     ),
     *      @OA\Response (
     *          response=401,
     *          description="Unauthenticated",
     *     )
     * )
     */
    public function getUser() {
        $user = AuthService::authUser();
        if ($user['success'] == TRUE) {
            return successResponse(__('found', ['key' => 'User']), $user['data']);
        }
        return errorResponse($user['message'], $user['data'], $user['status']);
    }

    /**
     * @OA\Put(
     *     path="/user/edit",
     *     description="Update user profile",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"first_name", "last_name", "avatar", "is_marketing", "address"},
     *            @OA\Property(property="first_name", type="string", format="string", example="admin@email.com"),
     *            @OA\Property(property="last_name", type="string", format="string", example="123456"),
     *            @OA\Property(property="avatar", type="string", format="string", example="123456"),
     *            @OA\Property(property="is_marketing", type="boolean", format="string", example="0"),
     *            @OA\Property(property="address", type="string", format="string", example="Bangladesh"),
     *         ),
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="Profile updated successfully",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Something went wrong",
     *      )
     * )
     */
    public function updateUserProfile(UpdateUserProfileRequest $request) {
        return $this->auth->updateUserProfile($request);
    }
}
