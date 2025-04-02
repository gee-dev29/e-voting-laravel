<?php

namespace App\Http\Controllers;

use App\Domain\Id\UserId;
use App\Http\ResponseInterface\ApiResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Psr\Http\Message\ServerRequestInterface;

class UserController extends Controller
{
    public function createUser(ServerRequestInterface $request, EntityManager $repository): ApiResponse
    {
        $userId = UserId::fromString($request->getAttribute('userId'));
        $post = $request->getParsedBody();
        $repository->persist(
            User::createUser(
                $userId,
                $post
            )
        );

        $repository->flush();
        return new ApiResponse(200);
    }

    public function getUser(ServerRequestInterface $request): JsonResponse
    {
        /** @var UserId */
        $userId = UserId::fromString($request->getAttribute('userId'));
        /** @var User */
        $user = User::find($userId->toString());
        return new JsonResponse($user->data());
    }

    public function getUsers(ServerRequestInterface $request): JsonResponse
    {
        $query = $request->getQueryParams();
        $criteria = $sort = $data = [];
        $limit = isset($query['limit']) ? intval($query['limit']) : 20;
        $skip = isset($query['skip']) ? intval($query['skip']) : 0;

        /** @var User[] */
        // $request->ge
        $users = User::findBy($criteria, $sort, $limit, $skip);
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
}
