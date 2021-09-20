<?php

namespace Jawabkom\Backend\Module\Translation\Contract;

use Jawabkom\Standard\Contract\IEntity;
use Jawabkom\Standard\Contract\IFilterComposite;
use Jawabkom\Standard\Contract\IRepository;

interface ITranslationRepository extends IRepository {

    public function saveEntity(ITranslationEntity|IEntity $entity): bool;

    public function createEntity(array $params = []): IEntity|ITranslationEntity;

    public function getByFilters(IFilterComposite $filterComposite = null, array $orderBy = [], $page = 1, $perPage=0):mixed;

    public function deleteEntity(mixed $entity):bool;

    public function truncateTranslations():bool;

    public function updateEntity($entity,array $params):bool;

}
