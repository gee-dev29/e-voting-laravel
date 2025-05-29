<?php

namespace App\Service;

use App\Models\User;

class OTPValidation
{

  public function validateOtp(User $user, string $inputOtp): bool
  {
    if (!$user->otp) {
      throw new \Exception("No OTP found.");
    }

    $expiresOn = \Carbon\Carbon::parse($user->otp->expiresOn);

    if (now()->greaterThan($expiresOn)) {
      throw new \Exception("OTP has expired.");
    }

    if ($user->otp->value !== $inputOtp) {
      throw new \Exception("Invalid OTP.");
    }

    return true;
  }
}
