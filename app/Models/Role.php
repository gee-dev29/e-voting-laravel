<?php

namespace App\Models;

use App\Http\Id\RoleId;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Role extends Model
{
    use HasFactory;

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

    protected $fillable = ['roleName'];
    protected $table = 'role';

    public static function createRole(array $data)
    {
        $validator = Validator::make($data, [
            'roleName' => 'required|string'
        ]);
        $validatedData = $validator->validate();

        $role = new self();
        $role->roleName = ucwords($validatedData['roleName']);
        return $role;
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'roleId', 'userId');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            Permission::class
        );
    }

    // Method to check if role has a specific permission
    public function hasPermission($permissionName)
    {
        return $this->permissions()->where('permissionName', $permissionName)->exists();
    }

    public function givePermissionTo($permission)
    {
        return $this->permission = $permission;
    }

    public function roleName(): string
    {
        return $this->roleName;
    }

    public function id(): RoleId
    {
        return RoleId::fromString($this->id);
    }

    public function data(): array
    {
        return [
            'id' => $this->id,
            'roleName' => $this->roleName
        ];
    }
}
