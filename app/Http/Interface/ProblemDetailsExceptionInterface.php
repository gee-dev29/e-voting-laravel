<?php

namespace App\Http\Exception;

interface ProblemDetailsExceptionInterface
{
  public function getStatus(): int;
  public function getType(): string;
  public function getTitle(): string;
  public function getDetail(): string;
}
