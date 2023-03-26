<?php

namespace App\Http\Middleware;

use App\Services\Auth\AuthService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
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
            return errorResponse(__('Unauthenticated'),[], 401);
        }
        if (!$user['data']->is_admin){
            return errorResponse(__('not_authorized'));
        }
        return $next($request);
    }
}
