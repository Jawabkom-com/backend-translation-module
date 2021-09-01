<?php

namespace Jawabkom\Standard\Contract;

interface IRepository
{
    public function save(IEntity $entity):bool;
}