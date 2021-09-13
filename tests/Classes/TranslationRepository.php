<?php

namespace Jawabkom\Backend\Module\Translation\Test\Classes;

use Jawabkom\Backend\Module\Translation\Contract\ITranslationEntity;
use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Standard\Contract\IEntity;
use Jawabkom\Standard\Contract\IFilterComposite;
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
         return  $this->where('group_name',$groupName)->get()->all();
    }

    public function findByKey(string $key):IRepository|ITranslationRepository|null
    {
        return $this->where('key',$key)->first();
    }

    public function deleteEntity(mixed $entity): bool
    {
      return $entity->delete();
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

    public function getByGroup(string $groupName): array|null
    {
      return $this->where('group_name',$groupName)->get()->all();
    }
    public function getByLocal(string $local): array|null
    {
      return $this->where('language_code',$local)->get()->all();
    }

    public function updateByKey(array $newValues): bool
    {
        try {
            return $this->update($newValues);
        }catch (\Throwable $exception){
            return false;
        }
     }

    public function findByValue(string $value): IRepository|ITranslationRepository|null
    {
       return $this->where('value',$value)->first();
    }

    public function getFilter(?string $key = '', ?string $value = '', ?string $local = '', ?string $groupName = '', ?string $countryCode = '', bool $paginate = true, int $perPage = 15)
    {
   $builder =  $this->when($key,function ($query,$key){
                    return $query->where('key',$key);
                })->when($value,function ($query,$value){
                     return $query->where('value',$value);
                })->when($local,function ($query,$local){
                    return $query->where('language_code',$local);
                })->when($groupName,function ($query,$groupName){
                    return $query->where('group_name',$groupName);
                })->when($countryCode,function ($query,$countryCode){
                    return $query->where('country_code',$countryCode);
                 });
   return  $paginate?$builder->paginate($perPage):$builder->get()->all();
 }

    public function getByFilters(IFilterComposite $filterComposite = null, $page = 1, $perPage = 0): array
    {
        // TODO: Implement getByFilters() method.
    }
}
