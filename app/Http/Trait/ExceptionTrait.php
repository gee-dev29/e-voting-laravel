<?php

declare(strict_types=1);

namespace App\Http\Trait;

use App\Http\Exception\ProblemDetailsExceptionInterface;
use Throwable;

trait ExceptionTrait
{
    const INVALID = 'Invalid';

    /**
     * Throw an exception from a Throwable
     *
     * @param ProblemDetailsExceptionInterface|Throwable $th
     * @return self
     */
    public static function fromThrowable(Throwable $th): self
    {
        $isCustomException = $th instanceof ProblemDetailsExceptionInterface;
        $detail = $th->getMessage();
        $e = new self($detail);
        $e->status = $isCustomException ? $th->getStatus() : 417;
        $e->title  = $isCustomException ? $th->getTitle() : static::INVALID;
        $e->detail = $detail;

        return $e;
    }
}
