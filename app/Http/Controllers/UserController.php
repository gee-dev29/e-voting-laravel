<?php

namespace App\Http\Controllers;

use App\Http\Id\UserId;
use App\Http\Requests\CreateUserRequest;
use App\Http\ResponseInterface\ApiResponse;
use App\Http\ResponseInterface\StatusCode;
use App\Http\Trait\RoleTrait;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController
{
    use RoleTrait;

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
        return new JsonResponse(array_merge($user->data(), [
            "roleName" => $this->getRoleName($user->roleId())
        ]));
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
            $data[] = array_merge($user->data(), [
                "roleName" => $this->getRoleName($user?->roleId())
            ]);
        }
        return new JsonResponse(
            [
                'totalRecords' => count($data),
                'data' => $data
            ]
        );
    }

    public function updateUserDetails(Request $request): JsonResponse
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

    public function deleteUser(CreateUserRequest $request): JsonResponse
    {
        try {
            $user = $request->attributes->get('user');
            $request->delete($user);
            return ApiResponse::success('User deleted successfully', StatusCode::OK);
        } catch (\Throwable $th) {
            return ApiResponse::error('Error deleting user', $th->getMessage(), StatusCode::BAD_REQUEST);
        }
    }

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

    public function loginUser(CreateUserRequest $request): JsonResponse
    {
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
