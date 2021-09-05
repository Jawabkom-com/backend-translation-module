<?php

namespace Jawabkom\Backend\Module\Translation\Test\Classes;

use Jawabkom\Backend\Module\Translation\Contract\ITranslationEntity;
use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Standard\Contract\IEntity;

class TranslationRepository extends AbstractTranslation implements ITranslationRepository
{
    public function createEntity(array $params=[]): TranslationEntity
    {
     return app()->make(ITranslationEntity::class);
    }

    public function saveEntity(ITranslationEntity|IEntity $entity): bool
    {
      return $entity->save();
    }

}