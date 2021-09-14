<?php

namespace Jawabkom\Backend\Module\Translation\Test\Classes;

use Doctrine\DBAL\Query\QueryBuilder;
use Jawabkom\Backend\Module\Translation\Contract\ITranslationEntity;
use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Standard\Contract\IAndFilterComposite;
use Jawabkom\Standard\Contract\IEntity;
use Jawabkom\Standard\Contract\IFilter;
use Jawabkom\Standard\Contract\IFilterComposite;
use Jawabkom\Standard\Contract\IOrderByFilterComposite;
use Jawabkom\Standard\Contract\IOrFilterComposite;
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

    public function getByFilters(IFilterComposite $filterComposite = null, array $orderBy = [], $page = 1, $perPage = 0): mixed
    {
        $builder = static::query();
        $this->filtersToWhereCondition($filterComposite, $builder);
//          foreach ($filterComposite->getChildren() as $type=>$child){
//              foreach ($child->toArray() as $column=> $item){
//                  foreach ($item as $op =>$value){
//                       $builder->{$type}($column,$op,$value);
//                  }
//               }
//          }
//          foreach ($orderByFilterComposite->getChildren() as $type=>$child){
//                foreach ($child->toArray() as $column=>$by){
//                        $builder->{$type}($column,$by);
//                  }
//           }
           if ($perPage){
            return  $builder->paginate($perPage);
/*              $currentPage           = ($page - 1) * $perPage;
              $result['resultCount'] = $builder->count();
              $result['currentPage'] = $currentPage;
              $result['perPage']     = $perPage;
              $result['result']      = $builder->take($perPage)->skip($currentPage)->get()->all();
              return $result;*/
          }
        return $builder->get()->all();
    }


    protected function filtersToWhereCondition(IFilterComposite $filterComposite, QueryBuilder $query) {
        foreach ($filterComposite->getChildren() as $child) {
            if($child instanceof IOrFilterComposite) {
                $query->orWhere(function ($q) use ($child) {
                    $this->filtersToWhereCondition($child, $q);
                });
            } elseif($child instanceof IAndFilterComposite) {
                $query->andWhere(function ($q) use($child) {
                    $this->filtersToWhereCondition($child, $q);
                });
            } elseif($child instanceof IFilter) {
                if($filterComposite instanceof IOrFilterComposite) {
                    $query->orWhere($child->getName(), $child->getOperation()??'=', $child->getValue());
                } else {
                    $query->andWhere($child->getName(), $child->getOperation()??'=', $child->getValue());
                }
            }
        }
    }

}
