<?php

declare(strict_types=1);

namespace App\Http\Trait;

use App\Models\Role;

trait RoleTrait
{
  private function getRoleName(string $roleId): ?string
  {
    /** @var Role */
    $role = Role::find($roleId);
    return $role?->roleName();
  }
}
