<?php

declare(strict_types=1);

namespace App\Domain;

interface IdInterface
{
  public static function fromString(string $id): self;

  public static function fromId(IdInterface $id): self;

  public static function generate(): self;

  public static function isValid(string $id): bool;

  public function toString(): string;

  public function __toString(): string;

  public function getId(): string;

  public function setId(string $id): void;
}
