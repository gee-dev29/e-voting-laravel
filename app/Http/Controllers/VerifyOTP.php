<?php

namespace App\Http\Controllers;

use App\Http\ResponseInterface\ApiResponse;
use App\Http\ResponseInterface\StatusCode;
use App\Models\User;
use App\Service\OTPValidation;
use Closure;
use Illuminate\Http\Request;

class VerifyOTP extends Controller
{
    protected OTPValidation $otpValidator;

    public function __construct(OTPValidation $otpValidator)
    {
        $this->otpValidator = $otpValidator;
    }
    private function __invoke(Request $request, Closure $next)
    {
        $user = $request->attributes->get('user');
        $request->validate(['otp' => 'required|string']);

        try {
            $this->otpValidator->validateOtp($user, $request->input('otp'));
            $user->otp = null;
            $user->save();

            return $next($request);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
