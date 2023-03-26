<?php

namespace App\Services\Admin\User;

use App\Http\Requests\Admin\StoreUserRequest;
use App\Models\User;
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
            return successResponse(__('created',['key' => 'User']), $user, 201);
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
        $user = User::query();
        if ($request->has('first_name') && $request->first_name != ''){
            $user = $user->where('first_name', 'like', '%'.$request->first_name.'%');
        }
        if ($request->has('email') && $request->email != ''){
            $user = $user->where('email', 'like', '%'.$request->email.'%');
        }
        if ($request->has('phone_number') && $request->phone_number != ''){
            $user = $user->where('phone_number', 'like', '%'.$request->phone_number.'%');
        }
        if ($request->has('address') && $request->address != ''){
            $user = $user->where('address', 'like', '%'.$request->address.'%');
        }
        if ($request->has('created_at') && $request->created_at != ''){
            $user = $user->whereDate('created_at', '<=', $request->created_at);
        }
        if ($request->has('marketing') && $request->marketing != ''){
            $user = $user->where('is_marketing', '=', $request->marketing);
        }
        $user = $user->paginate($limit);
        return successResponse(__('found',['key' => 'User']), $user);
    }

    /**
     * @param $uuid
     * update user by user uuid
     *
     * @return mixed
     */
    public function updateUpdate(StoreUserRequest $request, $uuid) {
        // TODO: Implement updateUpdate() method.
    }

    /**
     * @param $uuid
     * delete an user by uuid
     *
     * @return mixed
     */
    public function deleteUser($uuid) {
        // TODO: Implement deleteUser() method.
    }
}
