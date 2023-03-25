<?php

namespace App\Services;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\JwtToken;
use App\Models\User;
use App\Services\Auth\AuthInterface;
use Illuminate\Support\Facades\Hash;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Configuration;
use DateTimeImmutable;
use Lcobucci\JWT\Token\Parser;


class AuthService implements AuthInterface {
    /**
     * @param LoginRequest $request
     * login process for an user
     *
     * @return mixed
     */
    public function login_process(LoginRequest $request) {
        try {
            $valid = $this->check_credentials($request);
            if ($valid['success'] == FALSE) {
                return errorResponse($valid['message']);
            }

            $user = $valid['data'];
            $token = $this->issueJwtToken($user);
            $data = [
                'user'       => $user,
                'token_type' => 'Bearer',
                'token'      => $token
            ];
            return successResponse(__('Logged in successfully'), $data);
        } catch (\Exception $exception) {
            info(json_encode($exception->getMessage()));
            return errorResponse();
        }
    }

    /**
     * @param $request
     * check user credentials like email and password
     *
     * @return mixed
     */
    public function check_credentials($request) {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return errorReturn(__('not_found', ['key' => 'User']));
        }
        if ($user->email_verified_at == NULL) {
            return errorReturn(__('not_verified', ['key' => 'User email']));
        }
        if ($request->email === $user->email && Hash::check($request->password, $user->password)) {
            return successReturn(__('found', ['User credentials']), $user);
        }
        return errorReturn(__('not_matched', ['key' => 'User email or password']));
    }

    /**
     * @return mixed
     * create private and public key by open ssl to create token
     */
    public function createAndStoreKey() {
        $keyConfig = [
            "digest_alg"       => "sha256",
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ];

        $privateKey = openssl_pkey_new($keyConfig);
        openssl_pkey_export($privateKey, $pemPrivateKey);
        $keyDetails = openssl_pkey_get_details($privateKey);
        $pemPublicKey = $keyDetails["key"];
        file_put_contents(storage_path() . '/jwt-private-key.pem', $pemPrivateKey);
        file_put_contents(storage_path() . '/jwt-public-key.pem', $pemPublicKey);
    }

    /**
     * @param User $user
     *  create JWT token
     *
     * @return mixed
     */
    public function issueJwtToken($user) {
        $this->createAndStoreKey();
        $config = Configuration::forAsymmetricSigner(
            new Sha256(),
            InMemory::file(storage_path() . '/jwt-private-key.pem'),
            InMemory::file(storage_path() . '/jwt-public-key.pem')
        );

        $unique_id = uniqid('bh', FALSE);
        $issuer = $_SERVER['SERVER_NAME'];
        $title = time();
        $now = new DateTimeImmutable();
        $expired_at = $now->modify('+24 hour');
        $jwt = $config
            ->builder()
            ->issuedBy($issuer)
            ->permittedFor($issuer)
            ->relatedTo('user_uuid')
            ->identifiedBy($unique_id)
            ->issuedAt($now)
            ->canOnlyBeUsedAfter($now)
            ->expiresAt($expired_at)
            ->withClaim('user_uuid', $user->uuid)
            ->withHeader('title', $title)
            ->getToken($config->signer(), $config->signingKey());
        $this->storeJwtToken($unique_id, $user->id, $title, $expired_at);
        return $jwt->toString();
    }

    /**
     * @param $unique_id
     * @param $user_id
     * @param $title
     * @param $expired_at
     * store jwt token in db
     *
     * @return mixed
     */
    public function storeJwtToken($unique_id, $user_id, $title, $expired_at) {
        $jwt = JwtToken::where('user_id', $user_id)->first();
        $token_data = [
            'unique_id'    => $unique_id,
            'token_title'  => $title,
            'expires_at'   => $expired_at,
            'last_used_at' => now(),
        ];
        if (!$jwt) {
            $token_data['user_id'] = $user_id;
            JwtToken::create($token_data);
        } else {
            $jwt->update($token_data);
        }
    }

    /**
     * @return mixed
     * parse jwt token
     */
    public static function parseJwtToken() {
        $_token = request()->bearerToken();
        $parser = new Parser(new JoseEncoder());
        $token = $parser->parse($_token);
        if ($token->toString() == '') {
            return errorReturn(__('Unauthenticated'));
        }
        return successReturn('', ['token' => $token]);
    }

    /**
     * @return mixed
     * retrieve auth user data
     */
    public static function authUser() {
        $_token = self::parseJwtToken();
        if ($_token['success'] == FALSE) return $_token;
        $token = $_token['data']['token'];
        $user_uuid = $token->claims()->get('user_uuid');
        if ($user_uuid == '') {
            return errorReturn(__('Unauthenticated'));
        }
        $user = User::where('uuid', $user_uuid)->first();
        if (!$user) {
            return errorReturn(__('Unauthenticated'));
        }
        return successReturn(__('found', ['key' => 'User']), $user);
    }

    /**
     * @param $user_id
     * verify token with db
     *
     * @return mixed
     */
    public static function tokenVerify($user_id) {
        $jwt = JwtToken::where('user_id', $user_id)->first();
        if (!$jwt) {
            return errorReturn(__('Unauthenticated'));
        }
        return successReturn(__('found', ['key' => 'Token']), $jwt);
    }
}
