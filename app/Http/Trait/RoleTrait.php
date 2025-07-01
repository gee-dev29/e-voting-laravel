<?php

declare(strict_types=1);

namespace App\Http\Trait;

use App\Http\Id\UserId;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

trait RoleTrait
{
  private function getRoleName(string $roleId): ?string
  {
    /** @var Role */
    $role = Role::find($roleId);
    return $role?->roleName();
  }

  private function getUserRole(UserId $userId): array|string
  {
    $roleData = [];
    $userRoles = DB::table('role_user')->where(['userId' => $userId->toString()])->get();
    foreach ($userRoles as $userRole) {
      $role = Role::find($userRole->roleId);
      if ($role) {
        $roleData[] = [
          'roleId' => $role->id,
          'roleName' => $this->getRoleName($role->id)
        ];
      }
    }
    return $roleData;
  }
}
