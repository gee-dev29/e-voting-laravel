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
    $user = User::find($userId->toString());
    if (!$user) {
      throw UserException::notFound();
    }
    $request->attributes->set('user', $user);
    return $next($request);
  }
}
