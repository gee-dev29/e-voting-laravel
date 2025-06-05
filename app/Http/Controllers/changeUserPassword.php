<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\ResponseInterface\ApiResponse;
use App\Http\ResponseInterface\StatusCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class changeUserPassword extends Controller
{
    

    public function changeUserPassword(CreateUserRequest $request): JsonResponse
    {
        try {
            /** @var User */
            $user = $request->attributes->get('user');
            $post = $request->all();
            $user->changePassword($user, $post);
            return ApiResponse::success('User updated successfully', StatusCode::OK);
        } catch (\Throwable $e) {
            return ApiResponse::error('Error updating user', $e->getMessage(), StatusCode::BAD_REQUEST);
        }
    }
}
