<?php

namespace Jawabkom\Backend\Module\Translation\Test\Classes;

use Jawabkom\Backend\Module\Translation\Contract\ITranslationEntity;
use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Standard\Contract\IEntity;

class TranslationRepository extends AbstractTranslation implements ITranslationRepository
{
    public function createEntity(array $params=[]): TranslationEntity
    {
      return $this->model->create($params);
    }

    public function saveEntity(ITranslationEntity|IEntity $entity): bool
    {
      return $this->model->save($entity);
    }

}