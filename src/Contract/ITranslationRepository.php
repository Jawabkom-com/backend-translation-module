<?php

namespace Jawabkom\Backend\Module\Translation\Contract;

use Jawabkom\Standard\Contract\IEntity;
use Jawabkom\Standard\Contract\IRepository;

interface ITranslationRepository extends IRepository {

    public function saveEntity(ITranslationEntity|IEntity $entity): bool;
    public function createEntity(array $params = []): IEntity|ITranslationEntity;

    public function allTranslations():array;
    public function findByKey(string $key): IRepository|ITranslationRepository|null;
    public function findByValue(string $value): IRepository|ITranslationRepository|null;
    public function getByGroup(string $groupName):array|null;
    public function getByLocal(string $local): array|null;
    public function getByGroupName(string $groupName):array;

    public function deleteEntity():bool;
    public function truncateTranslations():bool;

    public function updateByKey(array $newValues):bool;

    public function setFilter(string|null $key='', string|null $value='',
                              string|null $local='',string|null $groupName='',
                              string|null $countryCode='',bool $paginate=true,
                              int $perPage=15);
}