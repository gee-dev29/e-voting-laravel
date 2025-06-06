<?php

namespace App\Models;

use App\Casts\OtpCast;
use App\Http\Id\RoleId;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
final class User extends Authenticatable implements MustVerifyEmail
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
    protected $guarded = [
        'id',
        'password',
        'otp'
    ];

    protected $casts = [
        'otp' => OtpCast::class,
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

    public static function updateUser(User $user, array $post): void
    {
        $validator = Validator::make($post, [
            'middleName' => 'required|string',
            'phone' => 'required|string',
            'roleId' => 'required|string',
        ]);

        $validatedData = $validator->validate();

        $user->middleName = ucwords($validatedData['middleName']);
        $user->phone = $validatedData['phone'];
        $user->roleId = $validatedData['roleId'];

        $user->save();
    }

    public function addRoles(array $roleIds): void
    {
        $this->roleIds = $roleIds;
    }

    public function changePassword(User $user, array $post)
    {
        $validator = Validator::make($post, [
            'password' => 'required|string',
        ]);

        $validatedData = $validator->validate();
        $hashedPassword = Hash("sha256", $validatedData['password']);
        $user->password = $hashedPassword;
    }

    public function password(): string
    {
        return $this->password;
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

    public function roleId(): ?RoleId
    {
        if ($this->roleId) {
            return RoleId::fromString($this->roleId);
        }
        return null;
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

    public function email(): string
    {
        return $this->email;
    }

    public function data(): array
    {
        return [
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->email,
            'phone' => $this->phone,
            'roleId' => $this->roleId ?? [],
            'middleName' => $this->middleName ?? null,
        ];
    }
}
