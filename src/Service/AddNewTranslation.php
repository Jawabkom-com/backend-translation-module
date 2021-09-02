<?php

namespace Jawabkom\Backend\Module\Translation\Service;

use Jawabkom\Backend\Module\Translation\Contract\ITranslation;
use Jawabkom\Backend\Module\Translation\Service\ParamsTrait\CountryCodeTrait;
use Jawabkom\Backend\Module\Translation\Service\ParamsTrait\LanguageCodeTrait;
use Jawabkom\Backend\Module\Translation\Service\ParamsTrait\TranslationGroupNameTrait;
use Jawabkom\Backend\Module\Translation\Service\ParamsTrait\TranslationKeyTrait;
use Jawabkom\Backend\Module\Translation\Service\ParamsTrait\TranslationValueTrait;
use Jawabkom\Standard\Abstract\AbstractService;

class AddNewTranslation extends AbstractService {
    use CountryCodeTrait;
    use LanguageCodeTrait;
    use TranslationGroupNameTrait;
    use TranslationValueTrait;
    use TranslationKeyTrait;

    private ITranslation $translation;

    public function __construct(ITranslation $translation)
    {

        $this->translation = $translation;
    }
    public function vaildtor():void{
        if (!$this->translationKey || !$this->translationValue){
            throw new \Exception('this is required filed');
        }
    }
    public function process(): static
    {
        $this->vaildtor();
        $this->createNewTranslationRecord();
        return $this;
    }

    private function createNewTranslationRecord()
    {
        $newRecord = $this->translation->createEntity();
        $newRecord->setCountryCode('');
        $newRecord->setLanguageCode('');
        $newRecord->setTranslationGroupName('');
        $newRecord->setTranslationKey('');
        $newRecord->setTranslationValue('');

        $this->setOutput('created',$this->translation->Save($newRecord));
    }
}