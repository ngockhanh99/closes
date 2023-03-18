<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role = '')
    {
        if ($request->user() && (empty($role) || $request->user()->hasRole($role)))
        {
            return $next($request);
        }
        if (strpos($request->headers->get("Authorization"),"Bearer ") !== false) {
            try {
                $user = JWTAuth::parseToken()->authenticate();
                if (!empty($role) && !$user->hasRole($role)){
                    return response()->json(['success' => false, 'message' => __('Bạn không có quyền thực hiện chức năng này.')], 401);
                }
            } catch (Exception $e) {
                if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                    return response()->json(['success' => false, 'message' => __('Token is Invalid')], 401);
                }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                    return response()->json(['success' => false, 'message' => __('Token is Expired')], 401);
                }else{
                    return response()->json(['success' => false, 'message' => __('Authorization Token not found')], 401);
                }
            }
            return $next($request);
        }
        //access permission denied
        return response()->json(['message' => 'Bạn không có quyền thực hiện chức năng này'], 403);
    }
}
