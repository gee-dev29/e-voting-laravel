<?php

declare(strict_types=1);

namespace App\Http\Trait;

trait CommonProblemDetailsExceptionTrait
{
  private int $status;
  private string $type;
  private string $title;
  private string $detail;

  public function getStatus(): int
  {
    return $this->status;
  }

  public function getType(): string
  {
    return $this->type;
  }

  public function getTitle(): string
  {
    return $this->title;
  }

  public function getDetail(): string
  {
    return $this->detail;
  }
}
