<?php

// namespace App\Http;

// use App\Models\User;

// class OtpService
// {
//   public function generateOtpForUser(User $user): string
//   {
//     $otp = rand(100000, 999999);

//     $user->otp = (object) [
//       'value' => $otp,
//       'createdOn' => now()->toISOString(),
//       'expiresOn' => now()->addMinutes(10)->toISOString(),
//     ];
//     $user->save();

//     return $otp;
//   }
// }
