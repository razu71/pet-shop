<?php

namespace App\Http\Middleware;

use App\Services\AuthService;
use Closure;
use Illuminate\Http\Request;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\Parser;
use Lcobucci\JWT\Validation\Constraint\IdentifiedBy;
use Lcobucci\JWT\Validation\Constraint\IssuedBy;
use Lcobucci\JWT\Validation\Constraint\PermittedFor;
use Lcobucci\JWT\Validation\Constraint\RelatedTo;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware {
    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response {
        $_token = $request->bearerToken();
        if ($_token == '') {
            return errorResponse(__('Unauthenticated'));
        }
        $parser = new Parser(new JoseEncoder());
        $token = $parser->parse($_token);
        $validator = new Validator();

        try {
            if ($token->isExpired(now())){
                return errorResponse(__('Unauthenticated'));
            }
            $user = AuthService::authUser();
            if ($user['success'] == FALSE) {
                return errorResponse(__('Unauthenticated'));
            }

            //verify token with db
            $user = $user['data'];
            $jwt = AuthService::tokenVerify($user->id);
            if ($jwt['success'] == FALSE) {
                return errorResponse(__('Unauthenticated'));
            }
            $jwt = $jwt['data'];

            //check token header
            $token_header = $token->headers()->get('title');
            if ($token_header != $jwt->token_title){
                return errorResponse(__('Unauthenticated'));
            }

            //validate token
            $public_key = InMemory::file(storage_path() . '/jwt-public-key.pem');
            if ($validator->validate($token,
                new SignedWith(new Sha256(), $public_key),
                new RelatedTo('user_uuid'),
                new IssuedBy($_SERVER['SERVER_NAME']),
                new permittedFor($_SERVER['SERVER_NAME']),
                new IdentifiedBy($jwt->unique_id)
            )) {
                return $next($request);
            }

            info('ok');
            return errorResponse(__('Unauthenticated'));
        } catch (\Exception $e) {
            info(json_encode($e->violations()));
            return errorResponse(__('Unauthenticated'));
        }
    }
}
