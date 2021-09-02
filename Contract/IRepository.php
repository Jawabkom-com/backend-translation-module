<?php

namespace Jawabkom\Standard\Contract;

interface IRepository
{
    public function createEntity(array $params):static;
    public function save(IEntity $entity):bool;
}