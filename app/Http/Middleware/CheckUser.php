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
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $userIdStr = $request->route('userId');
    if (!$userIdStr) {
      $post = $request->post();
      $userIdStr = $post['userId'] ?? null;
      if (!$post) {
        throw UserException::UserIdRequired();
        // retrieve userId from the login user
        $userIdStr = $request->userId;
      }
    }
    $userId = UserId::fromString($userIdStr);
    $user = User::find($userId->toString());
    $userModel = $user->getAttributes();
    if (!$user) {
      throw UserException::notFound();
    }
    unset($user['password']);
    $request->attributes->set('user', $user);
    return $next($request);
  }
}
