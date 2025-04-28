<?php

declare(strict_types=1);

namespace App\Domain\Exception;

use App\Http\Trait\ExceptionTrait;
use DomainException;
use Mezzio\ProblemDetails\Exception\CommonProblemDetailsExceptionTrait;
use Throwable;

class UserException extends DomainException implements ProblemDetailsExceptionInterface
{
    use CommonProblemDetailsExceptionTrait, ExceptionTrait;

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
}
