<?php

namespace App\Http\Controllers;

use App\Http\Trait\RoleTrait;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetUsers extends Controller
{
    use RoleTrait;
    public function __invoke(Request $request): JsonResponse
    {
        $query = $request->query();
        $data = [];
        $limit = isset($query['limit']) ? intval($query['limit']) : 20;
        $skip = isset($query['skip']) ? intval($query['skip']) : 0;
        $allowed = ['lastName', 'firstName', 'email'];
        $requested = array_keys($query);
        $filters = array_intersect($allowed, $requested);

        /**@var User */
        $usersQuery = User::query();
        foreach ($filters as $filter) {
            $usersQuery->where($filter, $query[$filter]);
        }
        $users = $usersQuery->skip($skip)->take($limit)->get();
        foreach ($users as $user) {
            $roleNames = [];
            $userRoles = $this->getUserRole($user->userId());
            foreach ($userRoles as $roleEntry) {
                $roleNames[] = $roleEntry['roleName'];
            }
            $data[] = array_merge($user->data(), [
                "roleName" => implode(', ', $roleNames)
            ]);
        }
        return new JsonResponse(
            [
                'totalRecords' => $usersQuery->count(),
                'data' => $data
            ]
        );
    }
}
