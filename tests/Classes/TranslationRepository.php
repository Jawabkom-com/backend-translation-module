<?php

namespace Jawabkom\Backend\Module\Translation\Test\Classes;

use Doctrine\DBAL\Query\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Jawabkom\Backend\Module\Translation\Contract\ITranslationEntity;
use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Standard\Contract\IAndFilterComposite;
use Jawabkom\Standard\Contract\IEntity;
use Jawabkom\Standard\Contract\IFilter;
use Jawabkom\Standard\Contract\IFilterComposite;
use Jawabkom\Standard\Contract\IOrFilterComposite;
use Jawabkom\Standard\Contract\IRepository;

class TranslationRepository extends AbstractTranslation implements IEntity, ITranslationEntity, ITranslationRepository
{

    public function setTranslationKey(string $translationKey)
    {
        $this->key = $translationKey;
    }

    public function getTranslationKey(): string
    {
        return $this->key;
    }

    public function setLanguageCode(string $language)
    {
        $this->language_code = $language;
    }

    public function getLanguageCode(): string
    {
        return $this->language_code;
    }

    public function setCountryCode(string $countryCode)
    {
        $this->country_code = $countryCode;
    }

    public function getCountryCode(): string
    {
        return $this->country_code;
    }

    public function setTranslationGroupName(string $groupName)
    {
        $this->group_name = $groupName;
    }

    public function getTranslationGroupName(): string
    {
        return $this->group_name;
    }

    public function setTranslationValue(string $translationValue)
    {
        $this->value = $translationValue;
    }

    public function getTranslationValue(): string
    {
        return $this->value;
    }

    public function createEntity(array $params = []): ITranslationEntity
    {
        return app()->make(ITranslationEntity::class);
    }

    public function saveEntity(ITranslationEntity|IEntity $entity): bool
    {
        return $entity->save();
    }

    public function insertBulk(array $params)
    {
        return $this->insert($params);
    }

    public function getByGroupName(string $groupName): array
    {
        return $this->where('group_name', $groupName)->get()->all();
    }

    public function findByKey(string $key): IRepository|ITranslationRepository|null
    {
        return $this->where('key', $key)->first();
    }

    public function deleteEntity(mixed $entity): bool
    {
        return $entity->delete();
    }

    public function allTranslations(): array
    {
        return $this->get()->all();
    }

    public function truncateTranslations(): bool
    {
        try {
            $this->truncate();
        } catch (\Throwable $exception) {
            return false;
        }
        return true;
    }

    public function getByGroup(string $groupName): array|null
    {
        return $this->where('group_name', $groupName)->get()->all();
    }

    public function getByLocal(string $local): array|null
    {
        return $this->where('language_code', $local)->get()->all();
    }

    public function updateEntity($entity, array $params): bool
    {
        try {
            return $entity->update($params);
        } catch (\Throwable $exception) {
            return false;
        }
    }

    public function findByValue(string $value): IRepository|ITranslationRepository|null
    {
        return $this->where('value', $value)->first();
    }

    public function getByFilters(IFilterComposite $filterComposite = null, array $orderBy = [], int $page = 1, int $perPage = 0): iterable
    {
        $builder = static::query();
        $this->filtersToWhereCondition($filterComposite, $builder);
 //        if ($perPage) {
//            return $builder->paginate($perPage);
//        }
        return $builder->get()->all();
    }


    protected function filtersToWhereCondition(IFilterComposite $filterComposite, $query)
    {

        foreach ($filterComposite->getChildren() as $child) {
            if ($child instanceof IOrFilterComposite) {
                $query->orWhere(function ($q) use ($child) {
                    $this->filtersToWhereCondition($child, $q);
                });
            } elseif ($child instanceof IAndFilterComposite) {
                $query->where(function ($q) use ($child) {
                    $this->filtersToWhereCondition($child, $q);
                });
            } elseif ($child instanceof IFilter) {
                if ($filterComposite instanceof IOrFilterComposite) {
                    $query->orWhere($child->getName(), $child->getOperation() ?? '=', $child->getValue());
                } else {
                    $query->Where($child->getName(), $child->getOperation() ?? '=', $child->getValue());
                }
            }
        }
    }

    public function getByKey(string $key, string $group = '', string $language = '', string $countryCode = ''): IEntity|ITranslationEntity|null
    {
        return $this->where('key', $key)
            ->when($group, function ($query, $group) {
                return $query->where('group_name', $group);
            })
            ->when($language, function ($query, $language) {
                return $query->where('language_code', $language);
            })
            ->when($countryCode, function ($query, $countryCode) {
                return $query->where('country_code', $countryCode);
            })->first();
    }
}
