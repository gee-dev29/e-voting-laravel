<?php

declare(strict_types=1);

namespace App\Http\Exception;

use App\Http\trait\CommonProblemDetailsExceptionTrait;
use App\Http\Interface\ProblemDetailsExceptionInterface;
use DomainException;

class IdException extends DomainException implements ProblemDetailsExceptionInterface
{
  use CommonProblemDetailsExceptionTrait;

  private const TYPE = 'https://example.com/probs/invalid-id';

  public static function notValid(string $identity): self
  {
    $detail = sprintf('Id "%s" is not valid', $identity);
    $e = new self($detail);
    $e->status = 409;
    $e->type   = self::TYPE;
    $e->title  = 'Invalid Id';
    $e->detail = $detail;

    return $e;
  }

  public static function alreadyExists(string $identity): self
  {
    $detail = sprintf(
      'Another Customer with different Email and Phone number already uses Identity Card with number %s',
      $identity
    );
    $e = new self($detail);
    $e->status = 409;
    $e->type   = self::TYPE;
    $e->title  = 'Unacceptable ID Number';
    $e->detail = $detail;

    return $e;
  }
}
