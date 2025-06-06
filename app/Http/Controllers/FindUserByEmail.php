<?php

namespace App\Http\Controllers;

use App\Http\Exception\UserException;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class FindUserByEmail
{
  public function __invoke(Request $request, Closure $next): Response
  {
    $validator = Validator::make($request->all(), [
      'email' => 'required|string|email'
    ]);

    $validatedData = $validator->validate();
    $user = User::where('email', $validatedData['email'])->first();

    $validatedData = $validator->validate();
    if ($validatedData['email'] !== $user->email()) {
      throw UserException::InvalidLoginCredential($user);
    }

    $request->attributes->set('user', $user);
    return $next($request);
  }
}
