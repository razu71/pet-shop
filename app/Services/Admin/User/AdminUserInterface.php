<?php

namespace App\Services\Admin\User;

use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Requests\User\UpdateUserProfileRequest;
use Illuminate\Http\Request;

interface AdminUserInterface {
    /**
     * @param StoreUserRequest $request
     * create a new user
     *
     * @return mixed
     */
    public function createNewUser(StoreUserRequest $request);

    /**
     * @param Request $request
     * user listing with some filter
     *
     * @return mixed
     */
    public function userListing(Request $request);

    /**
     * @param $uuid
     * update user by user uuid
     *
     * @return mixed
     */
    public function updateUpdate(UpdateUserRequest $request, $uuid);

    /**
     * @param $uuid
     * delete an user by uuid
     *
     * @return mixed
     */
    public function deleteUser($uuid);

    /**
     * @param UpdateUserProfileRequest $request
     * update user profile
     * @return mixed
     */
    public function updateUserProfile(UpdateUserProfileRequest $request);
}
