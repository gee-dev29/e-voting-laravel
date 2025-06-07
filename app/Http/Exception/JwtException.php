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
    $detail = sprintf(
      'Token not found'
    );
    $e = new self($detail);
    $e->status = 404;
    $e->title  = 'Token not found';
    $e->detail = $detail;

    return $e;
  }
  public static function inValidToken(): self
  {
    return new self('Invalid Token');
  }
}
