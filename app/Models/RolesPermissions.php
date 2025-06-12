<?php

namespace App\Models;

use App\Http\Id\RolePermissionId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

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

    public static function AddPermissionsToRole(array $data)
    {
        Validator::make($data, [
            'permissionId' => 'required|array',
            'roleId' => 'required|string'
        ]);

        $rolePermission = new self();
        return $rolePermission;
    }

    public function id(): RolePermissionId
    {
        return RolePermissionId::fromString($this->id);
    }

    public function data(): array
    {
        return [
            'id' => $this->id,
            'permissionId' => $this->permissionId,
            'roleId' => $this->roleId
        ];
    }
}
