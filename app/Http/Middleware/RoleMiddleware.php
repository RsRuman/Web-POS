<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next, $role, $permission = null)
    {

        if (!$request->user()->hasRole($role) || ($permission !== null && !$request->user()->can($permission))){
            if ($request->expectsJson()){
                return json_response('Failed', ResponseAlias::HTTP_UNAUTHORIZED, '', 'You do not have permission', false);
            }
            else{
                abort(401);
            }
        }
        return $next($request);
    }
}
