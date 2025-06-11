<?php

namespace App\Http\Middleware;

use App\Http\Exception\JwtException;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

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
            return response()->json(["error" => "Token not found"], 401);
        }
        try {
            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        } catch (\Firebase\JWT\ExpiredException $e) {
            return response()->json(["error" => $e->getMessage()], 401);
        }
        if (!$token) {
            throw JwtException::inValidToken();
        }
        $user = User::where(['email' => $decoded->email])->first()->getAttributes();
        unset($user['password']);
        $request->merge(['userId' => $user['id']]);
        return $next($request);
    }
}
