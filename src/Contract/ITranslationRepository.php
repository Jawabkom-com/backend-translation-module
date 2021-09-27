<?php

namespace Jawabkom\Backend\Module\Translation\Contract;

use Jawabkom\Standard\Contract\IEntity;
use Jawabkom\Standard\Contract\IFilterComposite;
use Jawabkom\Standard\Contract\IRepository;

interface ITranslationRepository extends IRepository {

    public function saveEntity(ITranslationEntity|IEntity $entity): bool;

    public function createEntity(array $params = []): IEntity|ITranslationEntity;

    /**
     * @param IFilterComposite|null $filterComposite
     * @param array $orderBy
     * @param int $page
     * @param int $perPage
     * @return ITranslationEntity[]
     */
    public function getByFilters(IFilterComposite $filterComposite = null, array $orderBy = [], int $page = 1, int $perPage=0):iterable;

    public function deleteEntity(ITranslationEntity|IEntity $entity):bool;

    public function getByKey(string $key, string $group = '', string $language = '', string $countryCode = ''): IEntity|ITranslationEntity|null;

}
