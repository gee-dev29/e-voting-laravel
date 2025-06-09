<?php

namespace App\Http\Id;

use App\Http\Exception\IdException;
use App\Http\Interface\IdInterface;
use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert as Assert;

abstract class Id implements IdInterface
{
    final protected function __construct(private string $id) {}

    public static function fromString(string $id): self
    {
        try {
            Assert::uuid($id, sprintf("\"%s\" is an invalid Id string", $id));
        } catch (\Throwable $th) {
            throw IdException::notValid($id);
        }
        return new static($id);
    }

    public static function fromId(IdInterface $id): self
    {
        return new static($id->toString());
    }

    public static function generate(): self
    {
        return new static(Uuid::uuid4()->toString());
    }

    public static function isValid(string $id): bool
    {
        return Uuid::isValid($id);
    }

    public function toString(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }
}
