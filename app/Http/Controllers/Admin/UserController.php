<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Services\Admin\User\AdminUserInterface;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class UserController extends Controller {
    public function __construct(private AdminUserInterface $admin) {
    }

    /**
     * @OA\Post(
     *     path="/admin/create",
     *     description="Create a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"first_name", "last_name", "email", "phone_number", "password", "password_confirmation"},
     *            @OA\Property(property="first_name", type="string", format="string", example="Mr."),
     *            @OA\Property(property="last_name", type="string", format="string", example="Admin"),
     *            @OA\Property(property="email", type="email", format="string", example="user@email.com"),
     *            @OA\Property(property="phone_number", type="string", format="string", example="+880175...."),
     *            @OA\Property(property="password", type="password", format="string", example="*****"),
     *            @OA\Property(property="password_confirmation", type="password", format="string", example="*****"),
     *         ),
     *      ),
     *     @OA\Response(
     *          response="200",
     *          description="User created successfully",
     *       ),
     *      @OA\Response(
     *          response="400",
     *          description="Something went wrong",
     *      ),
     * )
     */
    public function createNewUser(StoreUserRequest $request) {
        return $this->admin->createNewUser($request);
    }

    /**
     * @OA\Get(
     *     path="/admin/user-listing",
     *     description="User list",
     *     @OA\Parameter(name="page", in="query", description="No. of page", required=true,
     *        @OA\Schema(type="integer")
     *    ),
     *     @OA\Parameter(name="limit", in="query", description="How many record you want to get", required=true,
     *        @OA\Schema(type="integer")
     *    ),
     *     @OA\Parameter(name="first_name", in="query", description="First name of user", required=false,
     *        @OA\Schema(type="string")
     *    ),
     *     @OA\Parameter(name="email", in="query", description="User email", required=false,
     *        @OA\Schema(type="email")
     *    ),
     *     @OA\Parameter(name="phone_number", in="query", description="User phone", required=false,
     *        @OA\Schema(type="string")
     *    ),
     *     @OA\Parameter(name="address", in="query", description="User address", required=false,
     *        @OA\Schema(type="string")
     *    ),
     *     @OA\Parameter(name="created_at", in="query", description="Create time", required=false,
     *        @OA\Schema(type="datetime")
     *    ),
     *     @OA\Parameter(name="marketing", in="query", description="Is marketing or not", required=false,
     *        @OA\Schema(type="boolean")
     *    ),
     *     @OA\Response(
     *          response="200",
     *          description="User list",
     *       ),
     *      @OA\Response(
     *          response="400",
     *          description="Something went wrong",
     *      ),
     * )
     */
    public function userListing(Request $request) {
        return $this->admin->userListing($request);
    }

    /**
     * @OA\Put(
     *     path="/admin/user-edit/{uuid}",
     *     description="Update an user",
     *     @OA\Parameter(name="uuid", in="path", description="UUID of User", required=true,
     *        @OA\Schema(type="uuid")
     *    ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *            required={"first_name", "last_name", "email", "phone_number", "password", "password_confirmation"},
     *            @OA\Property(property="first_name", type="string", format="string", example="Mr."),
     *            @OA\Property(property="last_name", type="string", format="string", example="Admin"),
     *            @OA\Property(property="email", type="email", format="string", example="user@email.com"),
     *            @OA\Property(property="phone_number", type="string", format="string", example="+880175...."),
     *            @OA\Property(property="password", type="password", format="string", example="*****"),
     *            @OA\Property(property="password_confirmation", type="password", format="string", example="*****"),
     *         ),
     *      ),
     *     @OA\Response(
     *          response="200",
     *          description="User updated successfully",
     *       ),
     *      @OA\Response(
     *          response="400",
     *          description="Something went wrong",
     *      ),
     * )
     */
    public function updateUser(UpdateUserRequest $request, $uuid) {
        return $this->admin->updateUpdate($request, $uuid);
    }

    /**
     * @OA\Delete(
     *     path="/admin/user-delete/{uuid}",
     *     description="Delete an user",
     *     @OA\Parameter(name="uuid", in="path", description="UUID of User", required=true,
     *        @OA\Schema(type="uuid")
     *    ),
     *     @OA\Response(
     *          response="200",
     *          description="User deleted successfully",
     *       ),
     *      @OA\Response(
     *          response="400",
     *          description="Something went wrong",
     *      ),
     * )
     */
    public function deleteUser($uuid) {
        return $this->admin->deleteUser($uuid);
    }
}
