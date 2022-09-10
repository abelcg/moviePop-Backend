<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $isAdmin = $request->input('isAdmin');
            if (1 === $isAdmin) {
                $token = JWTAuth::parseToken()->authenticate();
                if (!$token) {
                    return response()->json(['message' => 'necesita de un token'], 500);
                }
            }else{
                throw new JWTException("Usted no es usuario Admin", 1);     
            }
        } catch (JWTException $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        } 
        return $next($request);
    }
}
