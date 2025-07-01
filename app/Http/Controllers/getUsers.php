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
        $users = User::query();
        foreach ($filters as $filter) {
            $users->where($filter, $query[$filter]);
        }
        $users = $users->skip($skip)->take($limit)->get();
        foreach ($users as $user) {
            $roleNames = [];
            $roleNames[] = $this->getUserRole($user->id);
            $data[] = array_merge($user->data(), [
                "roleName" => implode(', ', $roleNames)
            ]);
        }
        return new JsonResponse(
            [
                'totalRecords' => count($data),
                'data' => $data
            ]
        );
    }
}
