<?php

namespace App\Models;

use App\Http\Id\PermissionId;
use App\Http\Id\RolePermissionId;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RolesPermissions extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'role_permission';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }
        });
    }
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
            'permissionIds' => 'required|array',
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
        $rawPermissionIds = $this->attributes['permissionIds'];
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
            'permissionIds' => $this->permissionId,
            'roleId' => $this->roleId
        ];
    }
}
