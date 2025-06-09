<?php

namespace App\Http\Interface;

interface ProblemDetailsExceptionInterface
{
  public function getStatus(): int;
  public function getType(): string;
  public function getTitle(): string;
  public function getDetail(): string;
}
