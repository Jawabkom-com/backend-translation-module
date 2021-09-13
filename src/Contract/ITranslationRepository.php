<?php

namespace Jawabkom\Backend\Module\Translation\Contract;

use Jawabkom\Standard\Contract\IEntity;
use Jawabkom\Standard\Contract\IFilterComposite;
use Jawabkom\Standard\Contract\IRepository;

interface ITranslationRepository extends IRepository {

    public function saveEntity(ITranslationEntity|IEntity $entity): bool;
    public function createEntity(array $params = []): IEntity|ITranslationEntity;

    public function getByFilters(IFilterComposite $filterComposite = null, $page = 1, $perPage=0):array;

    public function deleteEntity(mixed $entity):bool;

    public function truncateTranslations():bool;

    public function updateByKey(array $newValues):bool;

    public function getFilter(string|null $key='', string|null $value='',
                              string|null $local='',string|null $groupName='',
                              string|null $countryCode='',bool $paginate=true,
                              int $perPage=15);
}
