<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolesPermissions extends Model
{
    protected $table = 'rolePermission';
    protected $fillable = [
        'roleId',
        'permissionIds',
    ];

    protected $cast = [
        'permissionIds'
    ];

    public function addPermissionsToRole($permissionId)
    {
        return $this->permissionId = $permissionId;
    }
}
