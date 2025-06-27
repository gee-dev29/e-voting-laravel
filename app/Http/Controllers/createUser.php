<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\ResponseInterface\ApiResponse;
use App\Http\ResponseInterface\StatusCode;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class CreateUser extends Controller
{
    public function __invoke(CreateUserRequest $request)
    {
        try {
            $post = $request->all();
            /** @var User */
            $user = User::createUser($post);
            $user->save();

            $existingRoleIds = Role::whereIn('id', $post['roleId'])->pluck('id')->toArray();
            if (count($existingRoleIds) !== count($post['roleId'])) {
                $invalidRoleIds = array_diff($post['roleId'], $existingRoleIds);
                throw ValidationException::withMessages([
                    'roleId' => 'One or more provided role IDs are invalid: ' . implode(', ', $invalidRoleIds),
                ]);
            }
            $user->roles()->attach($existingRoleIds);
            Log::info('User created successfully', ['userId' => $user->userId()]);
            return ApiResponse::success('User created successfully', StatusCode::CREATED);
        } catch (\Throwable $th) {
            Log::error('Error creating user', ['error' => $th->getMessage(), 'trace' => $th->getTraceAsString()]);
            return ApiResponse::error('Error creating user', $th->getMessage(), StatusCode::BAD_REQUEST);
        }
    }
}
