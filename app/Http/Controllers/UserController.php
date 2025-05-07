<?php

namespace App\Http\Controllers;

use App\Http\Id\UserId;
use App\Http\Requests\CreateUserRequest;
use App\Http\ResponseInterface\ApiResponse;
use App\Http\ResponseInterface\StatusCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController
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

    public function getUser(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->attributes->get('user');
        return new JsonResponse($user->data());
    }

    public function getUsers(Request $request): JsonResponse
    {
        $query = $request->getQueryString();
        $criteria = $data = [];
        $limit = isset($query['limit']) ? intval($query['limit']) : 20;
        $skip = isset($query['skip']) ? intval($query['skip']) : 0;

        if (isset($query['lastName'])) {
            $criteria = array_merge($criteria, ['lastName' => $query['lastName']]);
        }
        $queryBuilder = User::query($criteria);
        $users = $queryBuilder->skip($skip)->take($limit)->get();
        foreach ($users as $user) {
            $data[] = $user->data();
        }
        return new JsonResponse(
            [
                'totalRecords' => count($data),
                'data' => $data
            ]
        );
    }

    public function updateUser(Request $request): JsonResponse
    {
        try {
            $post = $request->all();
            /** @var User */
            $user = $request->user;
            $user->updateUser($post);
            return ApiResponse::success('User updated successfully', StatusCode::OK);
        } catch (\Throwable $th) {
            return ApiResponse::error('Error updating user', $th->getMessage(), StatusCode::BAD_REQUEST);
        }
    }

    public function deleteUser(CreateUserRequest $request): JsonResponse
    {
        try {
            $user = $request->user;
            $request->delete($user);
            return ApiResponse::success('User deleted successfully', StatusCode::OK);
        } catch (\Throwable $th) {
            return ApiResponse::error('Error deleting user', $th->getMessage(), StatusCode::BAD_REQUEST);
        }
    }

    public function changeUserPassword(CreateUserRequest $request): JsonResponse
    {
        try {
            //get the verified user from the check user middleware
            /** @var User */
            $user = $request->user;
            $post = $request->all();
            $user->changePassword($post);
            return ApiResponse::success('User updated successfully', StatusCode::OK);
        } catch (\Throwable $e) {
            return ApiResponse::error('Error updating user', $e->getMessage(), StatusCode::BAD_REQUEST);
        }
    }
}
