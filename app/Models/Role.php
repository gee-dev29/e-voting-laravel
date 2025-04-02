<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function users()
    {
        return $this->hasMany(User::class, 'roleId');
    }

    public function permissions()
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
}
