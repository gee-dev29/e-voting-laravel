<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\ResponseInterface\ApiResponse;
use App\Http\ResponseInterface\StatusCode;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class CreateUser extends Controller
{
    public function __invoke(CreateUserRequest $request)
    {
        try {
            $post = $request->all();
            $user = User::createUser($post);
            $user->save();
            Log::info('User created successfully', ['userId' => $user->id()]);
            return ApiResponse::success('User created successfully', StatusCode::CREATED);
        } catch (\Throwable $th) {
            Log::error('Error creating user', ['error' => $th->getMessage()]);
            return ApiResponse::error('Error creating user', $th->getMessage(), StatusCode::BAD_REQUEST);
        }
    }
}
