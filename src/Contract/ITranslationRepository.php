<?php

namespace Jawabkom\Backend\Module\Translation\Contract;

use Jawabkom\Standard\Contract\IEntity;
use Jawabkom\Standard\Contract\IRepository;

interface ITranslationRepository extends IRepository {

    public function saveEntity(ITranslationEntity|IEntity $entity): bool;
    public function createEntity(array $params = []): IEntity|ITranslationEntity;


    public function getByGroupName(string $groupName):array;
    public function allTranslations():array;
    public function findByKey(string $key): IRepository|ITranslationRepository|null;

}