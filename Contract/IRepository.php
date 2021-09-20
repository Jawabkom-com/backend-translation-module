<?php

namespace Jawabkom\Standard\Contract;

interface IRepository
{
    public function createEntity(array $params=[]):IEntity;
    public function saveEntity(IEntity $entity):bool;
    public function deleteEntity(IEntity $entity):bool;
}
