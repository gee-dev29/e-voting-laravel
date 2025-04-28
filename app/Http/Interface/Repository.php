<?php

use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;

interface RepositoryInterface extends ObjectRepository
{
  public function save(ObjectManager $document): void;
  public function update(ObjectManager $document): void;
  public function remove(ObjectManager $document): void;
  public function findOneAndRemove(array $criteria): void;
  public function createQueryBuilder(): QueryBuilder;
  public function clear(): void;
}
