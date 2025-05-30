<?php

declare(strict_types=1);

namespace App\Http\Exception;

use App\Http\Exception\CommonProblemDetailsExceptionTrait;
use App\Http\Trait\ExceptionTrait;
use App\Models\User;
use DomainException;

class UserException extends DomainException
{
    use CommonProblemDetailsExceptionTrait, ExceptionTrait;

    public static function notFound(): self
    {
        $detail = sprintf(
            'User Account not Found'
        );
        $e = new self($detail);
        $e->status = 404;
        $e->title  = 'User Not Found';
        $e->detail = $detail;

        return $e;
    }
    public static function UserIdRequired(): self
    {
        $detail = sprintf(
            'User ID required'
        );
        $e = new self($detail);
        $e->status = 404;
        $e->title  = 'User ID Not Found';
        $e->detail = $detail;

        return $e;
    }

    public static function InvalidLoginCredential(User $user): self
    {
        $detail = sprintf(
            'Invalid login credential for user with email: %s',
            $user->email()
        );
        $e = new self($detail);
        $e->status = 401; 
        $e->title  = 'Authentication Failed';
        $e->detail = $detail;

        return $e;
    }
}
