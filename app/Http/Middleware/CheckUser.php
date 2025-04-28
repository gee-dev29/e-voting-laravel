<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUser
{
  public function handle(Request $request, Closure $next): Response
  {
    $userId = $request->attributes->get('userId');
    if (!$userId) {
      $post = $request->post(['userId']);
      if (!$post) {
        throw new Exception('user id is required in the payload');
      }
      $userIdString = $post['userId'];
    }
    $userId = $userIdString;
    // query the user document for the specific user id 
    $user = User::find($userId);
    if (!$user) {
      throw new Exception(`user of this %userId is not found`);
    }
    return $next($request);
  }
}
