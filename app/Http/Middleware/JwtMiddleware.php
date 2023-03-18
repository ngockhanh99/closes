<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role = '')
    {
        if (strpos($request->headers->get("Authorization"),"Bearer ") === false) {
            $request->headers->set("Authorization","Bearer ".$request->headers->get("Authorization"));
        }

        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!empty($role) && !$user->hasRole($role)){
                return response()->json(['success' => false, 'message' => __('Bạn không có quyền thực hiện chức năng này!')], 401);
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
}
