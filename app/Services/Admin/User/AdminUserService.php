<?php

namespace App\Services\Admin\User;

use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Requests\User\UpdateUserProfileRequest;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

class AdminUserService implements AdminUserInterface {

    /**
     * @param StoreUserRequest $request
     * create a new user
     *
     * @return mixed
     */
    public function createNewUser(StoreUserRequest $request) {
        try {
            $data = $this->makeData($request);
            $data['uuid'] = uuid();
            $data['password'] = bcrypt($request->password);
            $user = User::create($data);
            return successResponse(__('created', ['key' => 'User']), $user, 201);
        } catch (\Exception $exception) {
            info(json_encode($exception->getMessage()));
            return errorResponse();
        }
    }

    public function makeData($request) {
        return [
            'first_name'   => $request->first_name,
            'last_name'    => $request->last_name,
            'email'        => $request->email,
            'phone_number' => $request->phone_number,
            'address'      => $request->address,
        ];
    }

    /**
     * @param Request $request
     * user listing with some filter
     *
     * @return mixed
     */
    public function userListing(Request $request) {
        $limit = $request->limit ?: 5;
        $user = User::where('is_admin','==',0);
        if ($request->has('first_name') && $request->first_name != '') {
            $user = $user->where('first_name', 'like', '%' . $request->first_name . '%');
        }
        if ($request->has('email') && $request->email != '') {
            $user = $user->where('email', 'like', '%' . $request->email . '%');
        }
        if ($request->has('phone_number') && $request->phone_number != '') {
            $user = $user->where('phone_number', 'like', '%' . $request->phone_number . '%');
        }
        if ($request->has('address') && $request->address != '') {
            $user = $user->where('address', 'like', '%' . $request->address . '%');
        }
        if ($request->has('created_at') && $request->created_at != '') {
            $user = $user->whereDate('created_at', '<=', $request->created_at);
        }
        if ($request->has('marketing') && $request->marketing != '') {
            $user = $user->where('is_marketing', '=', $request->marketing);
        }
        $user = $user->paginate($limit);
        return successResponse(__('found', ['key' => 'User']), $user);
    }

    /**
     * @param $uuid
     * update user by user uuid
     *
     * @return mixed
     */
    public function updateUpdate(UpdateUserRequest $request, $uuid) {
        try {
            $user = User::where('uuid', $uuid)->first();
            if (!$user) {
                return errorResponse(__('not_found', ['key' => 'User']));
            }
            $data = $this->makeData($request);
            if ($request->has('password') && $request->password != '') {
                $data['password'] = bcrypt($request->password);
            }
            if ($request->has('avatar') && $request->avatar != '') {
                $data['avatar'] = $request->avatar;
            }
            $user->update($data);
            return successResponse(__('updated', ['key' => 'User']), $user->refresh());
        } catch (\Exception $exception) {
            info(json_encode($exception->getMessage()));
            return errorResponse();
        }
    }

    /**
     * @param $uuid
     * delete an user by uuid
     *
     * @return mixed
     */
    public function deleteUser($uuid) {
        try {
            $user = User::where('uuid', $uuid)->first();
            if (!$user) {
                return errorResponse(__('not_found', ['key' => 'User']));
            }
            $user->delete();
            return successResponse(__('deleted', ['key' => 'user']));
        } catch (\Exception $exception) {
            info(json_encode($exception->getMessage()));
            return errorResponse();
        }
    }

    /**
     * @param UpdateUserProfileRequest $request
     * update user profile
     * @return mixed
     */
    public function updateUserProfile($request) {
        try {
            $user = AuthService::authUser();
            if ($user['success'] == FALSE){
                return errorResponse($user['message']);
            }
            $data = [
                'first_name'   => $request->first_name,
                'last_name'    => $request->first_name,
                'address'      => $request->address,
                'is_marketing' => $request->is_marketing,
                'avatar'       => $request->avatar,
            ];
            $user['data']->update($data);
            return successResponse(__('updated',['key'=>'Profile']), $user['data']->refresh());
        }catch (\Exception $exception){
            info(json_encode($exception->getMessage()));
            return errorResponse();
        }
    }
}
