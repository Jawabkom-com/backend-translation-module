<?php

namespace Jawabkom\Backend\Module\Translation\Repositories;

use Jawabkom\Backend\Module\Translation\Contract\ITranslation;
use Jawabkom\Standard\Contract\IEntity;
use JetBrains\PhpStorm\Pure;

/**
 * @property string $translationKey
 * @property string $languageCode
 * @property string $countryCode
 * @property string $translationGroupName
 * @property string $translationValue
 */
class TranslationRepository extends BasicRepository implements ITranslation
{
   public function createEntity(array $params): static
    {
     return $this->model->create($params);
    }

    public function save(IEntity $entity): bool
    {
      return $this->model->save($entity);
    }

    public function setTranslationKey(string $translationKey)
    {
        $this->translationKey = $translationKey;
    }

    public function getTranslationKey(): string
    {
     return $this->translationKey;
    }

    public function setLanguageCode(string $language)
    {
      $this->languageCode = $language;
    }

    public function getLanguageCode(): string
    {
        return $this->languageCode;
    }

    public function setCountryCode(string $countryCode)
    {
        $this->countryCode = $countryCode;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function setTranslationGroupName(string $groupName)
    {
        $this->translationGroupName = $groupName;
    }

    public function getTranslationGroupName(): string
    {
       return $this->translationGroupName;
    }

    public function setTranslationValue(string $translationValue)
    {
       $this->translationValue = $translationValue;
    }

    public function getTranslationValue(): string
    {
       return $this->translationValue;
    }

}