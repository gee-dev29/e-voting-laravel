<?php

declare(strict_types=1);

namespace App\Http\Exception;

use App\Http\Exception\CommonProblemDetailsExceptionTrait;
use App\Http\Trait\ExceptionTrait;
use DomainException;

class JwtException extends DomainException
{
  use CommonProblemDetailsExceptionTrait, ExceptionTrait;

  public static function noTokenFound(): self
  {
    return new self('Token not found.');
  }
  public static function inValidToken(): self
  {
    return new self('Invalid Token');
  }
}
