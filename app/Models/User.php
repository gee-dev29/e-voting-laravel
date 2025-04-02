<?php

namespace App\Models;

use App\Domain\Id\UserId;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Hash;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    private string $id;

    public function __construct(
        UserId $userId,

        /** @ORM\Column(type="string", length=255) */
        private string $firstName,

        /** @ORM\Column(type="string", length=255) */
        private string $lastName,

        /** @ORM\Column(type="string", length=255, nullable=true) */
        private ?string $middleName = null,

        /** @ORM\Column(type="string", length=255, unique=true) */
        private string $email,

        /** @ORM\Column(type="string", length=255) */
        private string $password,

        /** @ORM\Column(type="string", length=20, nullable=true) */
        private ?string $phone = null,

        /** @ORM\Column(type="json") */
        private array $roleId = [],

        /** @ORM\Column(type="datetime", nullable=true) */
        private ?\DateTimeInterface $emailVerifiedAt = null,

        /** @ORM\ManyToOne(targetEntity="Role") */
        private ?Role $role = null

    ) {
        $this->id = $userId->toString();
    }

    public static function createUser(UserId $userId, array $post): static
    {
        try {
            Assert::notEmpty($post['firstName'], 'First name is required');
            Assert::notEmpty($post['lastName'], 'Last name is required');
            Assert::notEmpty($post['phone'], 'Phone is required');
            Assert::notEmpty($post['password'], 'Password is required');
            Assert::notEmpty($post['email'], 'Email is required');

            Assert::email($post['email'], 'Must be a valid email address');
            Assert::minLength($post['firstName'], 2, 'First Name must not be less than 2 characters');
            Assert::minLength($post['lastName'], 2, 'Last Name must not be less than 2 characters');

            $hashPassword = bcrypt($post['password']);
            $email = strtolower($post['email']);
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }

        return new static(
            userId: $userId,
            firstName: $post['firstName'],
            lastName: $post['lastName'],
            email: $email,
            password: $hashPassword,
            phone: $post['phone'] ?? null,
            middleName: $post['middleName'] ?? null
        );
    }

    public function id(): UserId
    {
        return UserId::fromString($this->id);
    }

    public function  stringedId(): string
    {
        return $this->id;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function middleName(): ?string
    {
        return $this->middleName;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function phone(): ?string
    {
        return $this->phone;
    }

    public function roleId(): array
    {
        return $this->roleId;
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
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'middleName' => $this->middleName,
            'email' => $this->email,
            'phone' => $this->phone,
            'roleId' => $this->roleId,
        ];
    }
}
