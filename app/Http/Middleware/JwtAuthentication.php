<?php

namespace App\Http\Middleware;

use App\Http\Exception\JwtException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT;

class JwtAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        if (!$token) {
            throw JwtException::noTokenFound();
        }
        $decoded = JWT::decode($token, env('JWT_SECRET'));
        if (!$token) {
            throw JwtException::inValidToken();
        }
        var_dump($decoded);
        // $userId  = $decoded->id
        return $next($request);
    }
}
