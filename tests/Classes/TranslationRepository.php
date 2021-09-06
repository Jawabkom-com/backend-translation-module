<?php

namespace Jawabkom\Backend\Module\Translation\Test\Classes;

use Jawabkom\Backend\Module\Translation\Contract\ITranslationEntity;
use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Standard\Contract\IEntity;
use Jawabkom\Standard\Contract\IRepository;

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

    public function insertBulk(array $params){
        return  $this->insert($params);
    }

    public function getByGroupName(string $groupName): array
    {

    }

    public function findByKey(string $key):IRepository|ITranslationRepository|null
    {
        return $this->where('key',$key)->first();
    }

    public function deleteEntity(): bool
    {
      return $this->delete();
    }

    public function allTranslations():array
    {
     return $this->get()->all();
    }

    public function truncateTranslations():bool{
        try {
            $this->truncate();
        }catch (\Throwable $exception){
            return false;
        }
        return true;
    }
}