<?php

declare(strict_types=1);

namespace App\Http\Exception;

use App\Http\Exception\CommonProblemDetailsExceptionTrait;
use App\Http\Trait\ExceptionTrait;
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
}
