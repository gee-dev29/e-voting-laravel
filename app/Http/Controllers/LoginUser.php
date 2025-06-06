<?php

namespace App\Http\Controllers;

use Firebase\JWT\JWT;
use Illuminate\Http\Request;

class LoginUser extends Controller
{
    public function __invoke(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'email' => 'required|string|email'
        // ]);

        // $validatedData = $validator->validate();
        // $user = User::where('email', $validatedData['email'])->first();

        // $validatedData = $validator->validate();
        // if ($validatedData['email'] !== $user->email() &&  !Hash::check($validatedData['password'], $user->password())) {
        //     throw UserException::InvalidLoginCredential($user);
        // }
        $user = $request->attributes->get('user');
        $payload = [
            'iss' => "your-app",
            'sub' => $user->id,
            'email' => $user->email,
            'iat' => time(),
            'exp' => time() + 3600
        ];
        $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');
        return response()->json([
            'message' => 'Login successful',
            'token'   => $token,
            'user'    => $user
        ]);
    }

    //  public function login(Request $request)
    // {
    //     $request->validate([
    //         'email'    => 'required|email',
    //         'password' => 'required|string'
    //     ]);

    //     if (!Auth::attempt($request->only('email', 'password'))) {
    //         return response()->json(['message' => 'Login successful',
    //         'token'   => $token,
    //         'user'    => $user], 401);
    //     }

    //     $user = Auth::user();

    //     if (!$user->email_verified_at) {
    //         return response()->json(['error' => 'Please verify your OTP before logging in'], 403);
    //     }

    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return response()->json([
    //         'message' => 'Login successful',
    //         'token'   => $token,
    //         'user'    => $user
    //     ]);
    // }
}
