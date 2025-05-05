<?php

declare(strict_types=1);

namespace App\Http\Exception;

use App\Http\Exception\CommonProblemDetailsExceptionTrait as ExceptionCommonProblemDetailsExceptionTrait;
use App\Http\Exception\ProblemDetailsExceptionInterface;
use App\Http\Trait\ExceptionTrait;
use DomainException;
use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Throwable;

class UserException extends DomainException implements ProblemDetailsExceptionInterface
{
    use ExceptionCommonProblemDetailsExceptionTrait, ExceptionTrait;

    public static function notFound(): self
    {
        $detail = sprintf(
            'User Account not Found'
        );
        $e = new self($detail);
        $e->status = 404;
        $e->type   = self::TYPE;
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
        $e->type   = self::TYPE;
        $e->title  = 'User ID Not Found';
        $e->detail = $detail;

        return $e;
    }
}

