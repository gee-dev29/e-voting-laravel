<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\ResponseInterface\ApiResponse;
use App\Http\ResponseInterface\StatusCode;
use App\Models\User;

class createUser extends Controller
{
    public function createUser(CreateUserRequest $request)
    {
        try {
            $post = $request->all();
            $user = User::createUser($post);
            $user->save();
            return ApiResponse::success('User created successfully', StatusCode::CREATED);
        } catch (\Throwable $th) {
            return ApiResponse::error('Error creating user', $th->getMessage(), StatusCode::BAD_REQUEST);
        }
    }
}
