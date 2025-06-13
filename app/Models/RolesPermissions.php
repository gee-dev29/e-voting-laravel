<?php

namespace App\Models;

use App\Http\Id\PermissionId;
use App\Http\Id\RolePermissionId;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class RolesPermissions extends Model
{
    protected $table = 'rolePermission';
    protected $fillable = [
        'roleId',
        'permissionId',
    ];

    protected $cast = [
        'permissionId'
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

    public function permissionIds(): array
    {
        $rawPermissionIds = $this->attributes['permissionId'];
        $parsedPermissionIds = [];
        if (is_string($rawPermissionIds) && ($decoded = json_decode($rawPermissionIds, true)) !== null && is_array($decoded)) {
            $parsedPermissionIds = $decoded;
        } elseif (is_string($rawPermissionIds)) {
            $parsedPermissionIds = (string)$rawPermissionIds;
        } elseif (is_array($rawPermissionIds)) {
            $parsedPermissionIds = $rawPermissionIds;
        } elseif (is_null($rawPermissionIds)) {
            $parsedPermissionIds = (array)$rawPermissionIds;
        }
        $permissionIdsObject = [];
        foreach ($parsedPermissionIds as $idString) {
            try {
                $permissionIdsObject[] = PermissionId::fromString((string)$idString);
            } catch (\Throwable $th) {
                throw new Exception($th);
            }
        }
        return $permissionIdsObject;
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
