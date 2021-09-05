<?php

namespace Jawabkom\Backend\Module\Translation\Contract;

use Jawabkom\Standard\Contract\IEntity;

interface ITranslationEntity extends IEntity {

    public function setTranslationKey(string $translationKey);
    public function getTranslationKey():string;

    public function setLanguageCode(string $language);
    public function getLanguageCode():string;

    public function setCountryCode(string $countryCode);
    public function getCountryCode():string;

    public function setTranslationGroupName(string $groupName);
    public function getTranslationGroupName():string;

    public function setTranslationValue(string $translationValue);
    public function getTranslationValue():string;

}