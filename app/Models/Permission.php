<?php

namespace App\Models;

use App\Http\Id\PermissionId;
use App\Http\Requests\CreatePermissionRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Permission extends Model
{
    protected $table = 'permission';
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }
        });
    }

    protected $fillable = ['permissionName', 'description'];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permission', 'permissionId', 'roleId');
    }

    public function id(): PermissionId
    {
        return PermissionId::fromString($this->id);
    }

    public function data(): array
    {
        return [
            'permissionName' => $this->permissionName,
            'description' => $this->description,
        ];
    }
}
