<?php

namespace Jawabkom\Backend\Module\Translation\Test\Classes;

 use Jawabkom\Backend\Module\Translation\AbstractTranslation;
 use Jawabkom\Backend\Module\Translation\Contract\ITranslationEntity;
 use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;

 class TranslationEntity extends AbstractTranslation implements ITranslationEntity
{

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