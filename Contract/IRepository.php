<?php

namespace Jawabkom\Standard\Contract;

use Jawabkom\Backend\Module\Translation\Test\Classes\TranslationEntity;

interface IRepository
{
    public function createEntity(array $params=[]):IEntity;
    public function saveEntity(IEntity $entity):bool;
    public function insertBulk(array $params);
    public function deleteEntity():bool;

}
