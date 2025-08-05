<?php

namespace App\Http\Controllers;

use App\Http\ResponseInterface\ApiResponse;
use App\Http\ResponseInterface\StatusCode;
use Illuminate\Http\Request;

class GenerateOTP extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $user = $request->attributes->get('user');
            $user->otp = (object) [ 
                'value' => rand(100000, 999999),
                'createdOn' => now()->toISOString(),
                'expiresOn' => now()->addMinutes(10)->toISOString(),
            ];
            $user->save();
            return ApiResponse::success('OTP generated successfully.', StatusCode::OK);
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}