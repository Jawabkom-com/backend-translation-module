<?php

namespace Jawabkom\Backend\Module\Translation\Contract;

use Jawabkom\Standard\Contract\IEntity;
use Jawabkom\Standard\Contract\IFilterComposite;
use Jawabkom\Standard\Contract\IRepository;

interface ITranslationRepository extends IRepository {

    public function saveEntity(ITranslationEntity|IEntity $entity): bool;

    public function createEntity(array $params = []): IEntity|ITranslationEntity;

    public function getByFilters(IFilterComposite $filterComposite = null, array $orderBy = [], $page = 1, $perPage=0):iterable;

    public function deleteEntity(ITranslationEntity|IEntity $entity):bool;

    public function getByKey(string $key, string $group = '', string $language = '', string $countryCode = ''): IEntity|ITranslationEntity|null;

}
