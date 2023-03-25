<?php

namespace App\Services\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;

interface AuthInterface {
    /**
     * @param LoginRequest $request
     * login process for an user
     *
     * @return mixed
     */
    public function login_process(LoginRequest $request);

    /**
     * @param $request
     * check user credentials like email and password
     *
     * @return mixed
     */
    public function check_credentials($request);

    /**
     * @return mixed
     * create private and public key by open ssl to create token
     */
    public function createAndStoreKey();

    /**
     * @param User $user
     *  create JWT token
     *
     * @return mixed
     */
    public function issueJwtToken(User $user);

    /**
     * @param $unique_id
     * @param $user_id
     * @param $title
     * @param $expired_at
     * store jwt token in db
     *
     * @return mixed
     */
    public function storeJwtToken($unique_id, $user_id, $title, $expired_at);

    /**
     * @return mixed
     * parse jwt token
     */
    public static function parseJwtToken();

    /**
     * @return mixed
     * retrieve auth user data
     */
    public static function authUser();

    /**
     * @param $user_id
     * verify token with db
     *
     * @return mixed
     */
    public static function tokenVerify($user_id);
}
