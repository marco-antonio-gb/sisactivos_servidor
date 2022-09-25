<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;


class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
//                return response()->json(['status' => 'Token is Invalid']);
                return response()->json([
                    'success' => false,
                    'message' => 'El Token es invalido',
                ], 200);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
//                return response()->json(['status' => 'Token is Expired']);
                return response()->json([
                    'success' => false,
                    'message' => 'El Token expiro',
                ], 200);
            }else{
//                return response()->json(['status' => 'Authorization Token not found']);
                return response()->json([
                    'success' => false,
                    'message' => 'El Token de autorizacion no es valido',
                ], 200);
            }
        }
        return $next($request);

    }
}
