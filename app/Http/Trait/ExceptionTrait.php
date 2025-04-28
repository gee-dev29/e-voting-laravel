<?php

declare(strict_types=1);

namespace App\Http\Trait;

use App\Http\Exception\ProblemDetailsExceptionInterface as ExceptionProblemDetailsExceptionInterface;
use Mezzio\ProblemDetails\Exception\ProblemDetailsExceptionInterface;
use Throwable;

trait ExceptionTrait
{
    const INVALID='Invalid';
    const TYPE = 'https://accountable.com.ng';
    
    /**
     * Throw an exception from a Throwable
     *
     * @param ProblemDetailsExceptionInterface|Throwable $th
     * @return self
     */
    public static function fromThrowable(Throwable $th): self
    {
        $isCustomException = $th instanceof ExceptionProblemDetailsExceptionInterface;
        $detail = $th->getMessage();
        $e = new self($detail);
        $e->status = $isCustomException ? $th->getStatus() : 417;
        $e->type   = self::TYPE;
        $e->title  = $isCustomException ? $th->getTitle() : static::INVALID;
        $e->detail = $detail;

        return $e;
    }
}
