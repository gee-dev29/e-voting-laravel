<?php

declare(strict_types=1);

namespace App\Http\Trait;

use App\Http\Id\UserId;
use App\Models\User;

trait UserTrait
{
  public function getUser(UserId $userId): User
  {
    /**@var User */
    $user = User::find($userId);
    return $user;
  }
}
