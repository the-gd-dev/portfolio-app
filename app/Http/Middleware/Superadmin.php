<?php

namespace App\Http\Middleware;

use Closure;

class Superadmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $is_superadmin =  \Auth::guard($guard)->user()->role_id == 1;
        if (!$is_superadmin) {
            if($request->ajax()){
                return response()->json(['errors' => ['message' => 'You\'re not authenticated.']], 401);
            }
            return abort(401);
        }
        return $next($request);
    }
}
