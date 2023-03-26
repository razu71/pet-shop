<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserProfileRequest;
use App\Services\Admin\User\AdminUserInterface;
use App\Services\Auth\AuthInterface;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

class ProfileController extends Controller {
    public function __construct(private AdminUserInterface $auth) {
    }

    public function getUser() {
        $user = AuthService::authUser();
        if ($user['success'] == TRUE) {
            return successResponse(__('found', ['key' => 'User']), $user['data']);
        }
        return errorResponse($user['message'], $user['data'], $user['status']);
    }

    public function updateUserProfile(UpdateUserProfileRequest $request) {
        return $this->auth->updateUserProfile($request);
    }
}
