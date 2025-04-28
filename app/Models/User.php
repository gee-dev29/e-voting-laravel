<?php

namespace App\Models;

use Doctrine\ORM\Mapping as ORM;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Throwable;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    public $incrementing = false;
    protected $table = 'users';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid();
            }
        });
    }
    // protected $fillable = [
    //     'firstName',
    //     'lastName',
    //     'middleName',
    //     'email',
    //     'password',
    // ];
    protected $guarded = [
        'id',
        // 'firstName',
        // 'lastName',
        // 'email',
        'password',
    ];

    public static function createUser(array $data)
    {
        $validator = Validator::make($data, [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $validatedData = $validator->validate();
        $hashedPassword = Hash("sha256", $validatedData['password']);

        $user = new self();
        $user->firstName = ucwords($validatedData['firstName']);
        $user->lastName = ucwords($validatedData['lastName']);
        $user->email = $validatedData['email'];
        $user->password = $hashedPassword;

        return $user;
    }

    public static function updateUser(array $post): void
    {
        $validator = Validator::make($post, [
            'middleName' => 'required|string',
            'phone' => 'required|string',
            'roleIds' => 'required|array',
        ]);

        $validatedData = $validator->validate();
        $middleName = ucwords($validatedData['middleName']);
        // $user = 
    }

    public function addRoles(array $roleIds): void
    {
        $this->roleIds = $roleIds;
    }


    // public function createOTP(): void
    // {
    //     $this->otp = OTP::create();
    // }

    // public function otp(): ?OTP
    // {
    //     if (isset($this->otp)) {
    //         return $this->otp;
    //     }
    //     return null;
    // }

    public function roleId(): array
    {
        return $this->roleId ?? [];
    }

    public function role(): ?Role
    {
        return $this->role;
    }

    public function hasRole(string $roleName): bool
    {
        return $this->role && $this->role->getRoleName() === $roleName;
    }

    public function hasPermission(string $permissionName): bool
    {
        return $this->role && $this->role->hasPermission($permissionName);
    }

    public function data(): array
    {
        return [
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'phone' => $this->phone ?? null,
            'roleId' => $this->roleId ?? [],
            'middleName' => $this->middleName ?? null,
        ];
    }
}
