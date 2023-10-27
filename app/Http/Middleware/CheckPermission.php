<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permissions)
    {

        $permissions = explode('|', $permissions);

        if (is_array($permissions)) {
            foreach ($permissions as $permission) {
                abort_unless($request->user()->can($permission), Response::HTTP_FORBIDDEN);
            }
        } else {
            abort_unless($request->user()->can($permissions), Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
