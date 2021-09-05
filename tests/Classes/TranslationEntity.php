<?php

namespace Jawabkom\Backend\Module\Translation\Test\Classes;

 use Jawabkom\Backend\Module\Translation\Contract\ITranslationEntity;
 use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;

 class TranslationEntity extends AbstractTranslation implements ITranslationEntity
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

}