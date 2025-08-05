<?php

namespace App\Http\Controllers;

use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class LoginUser extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->attributes->get('user');
        $payload = [
            'iss' => "e-voting-system",
            'sub' => $user->id,
            'email' => $user->email,
            'iat' => time(),
            'exp' => time() + 86400
        ]; 
        $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');
        return response()->json([
            'message' => 'Login successful',
            'token'   => $token,
        ]); 
    }
}
