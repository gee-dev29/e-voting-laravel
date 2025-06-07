<?php

declare(strict_types=1);

namespace App\Http\Exception;

use App\Http\Exception\CommonProblemDetailsExceptionTrait;
use App\Http\Trait\ExceptionTrait;
use DomainException;

class RoleException extends DomainException
{
  use CommonProblemDetailsExceptionTrait, ExceptionTrait;

  public static function unAuthorizedUser(): self
  {
    return new self('User not authorized to perform this action');
  }
}
