<?php

namespace App\Http\Middleware;

use App\Services\AuthService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use const _PHPStan_e0e4f009c\__;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = AuthService::authUser();
        if ($user['success'] == FALSE){
            return errorResponse(__('Unauthenticated'));
        }
        if ($user['data']->is_admin){
            return errorResponse(__('not_authorized'));
        }
        return $next($request);
    }
}
