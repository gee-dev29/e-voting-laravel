<?php

namespace App\Http\Controllers;

use App\Http\ResponseInterface\ApiResponse;
use App\Http\ResponseInterface\StatusCode;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UpdateUserDetails extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $post = $request->all();
            /** @var User */
            $user = $request->attributes->get('user');
            $user->updateUser($user, $post);
            return ApiResponse::success('User updated successfully', StatusCode::OK);
        } catch (\Throwable $th) {
            return ApiResponse::error('Error updating user', $th->getMessage(), StatusCode::BAD_REQUEST);
        }
    }
}
