<?php

namespace App\Http\Middleware;

use App\Http\Exception\UserException;
use App\Http\Id\UserId;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUser
{
  public function handle(Request $request, Closure $next): Response
  {
    $userId = $request->route('userId');
    if (!$userId) {
      $post = $request->post(['userId']);
      $userId = $post['userId'];
      if (!$post) {
        throw UserException::UserIdRequired();
      }
    }
    $userId = UserId::fromString($userId);
    $user = User::find(['id' => $userId->toString()]);
    if (!$user) {
      throw UserException::notFound();
    }
    return $next($request);
  }

  //   <?php

  // namespace App\Http\Middleware;

  // use App\Models\User;
  // use Closure;
  // use Illuminate\Http\Request;
  // use Symfony\Component\HttpFoundation\Response;
  // use Illuminate\Http\Exceptions\HttpResponseException;

  // class CheckUser
  // {
  //     public function handle(Request $request, Closure $next): Response
  //     {
  //         // Retrieve 'userId' from request input (handles both JSON and form data)
  //         $userId = $request->input('userId');

  //         if (!$userId) {
  //             // Return a 400 Bad Request response if 'userId' is missing
  //             throw new HttpResponseException(response()->json([
  //                 'message' => 'userId is required in the payload'
  //             ], 400));
  //         }

  //         // Attempt to retrieve the user by ID
  //         $user = User::find($userId);

  //         if (!$user) {
  //             // Return a 404 Not Found response if user does not exist
  //             throw new HttpResponseException(response()->json([
  //                 'message' => "User with ID {$userId} not found"
  //             ], 404));
  //         }

  //         // Attach the user object to the request for downstream access
  //         $request->setUserResolver(function () use ($user) {
  //             return $user;
  //         });

  //         return $next($request);
  //     }
}

// }
