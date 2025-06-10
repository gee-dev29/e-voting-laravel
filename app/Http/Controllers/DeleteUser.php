<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\ResponseInterface\ApiResponse;
use App\Http\ResponseInterface\StatusCode;
use Illuminate\Http\JsonResponse;

class DeleteUser extends Controller
{
    public function __invoke(CreateUserRequest $request): JsonResponse
    {
        try {
            $user = $request->attributes->get('user');
            $request->delete($user);
            return ApiResponse::success('User deleted successfully', StatusCode::OK);
        } catch (\Throwable $th) {
            return ApiResponse::error('Error deleting user', $th->getMessage(), StatusCode::BAD_REQUEST);
        }
    }
}
