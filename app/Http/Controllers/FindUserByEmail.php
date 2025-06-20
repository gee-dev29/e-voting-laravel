<?php

namespace App\Http\Controllers;

use App\Http\Exception\UserException;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FindUserByEmail extends Controller
{
    public function __invoke(Request $request, Closure $next)
    {
        try {
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
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
