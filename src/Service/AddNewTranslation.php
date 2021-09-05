<?php

namespace Jawabkom\Backend\Module\Translation\Service;

use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Standard\Abstract\AbstractService;

class AddNewTranslation extends AbstractService {

    private ITranslationRepository $translationRepository;

    public function __construct(ITranslationRepository $ITranslationRepository,)
    {
        $this->translationRepository = $ITranslationRepository;
    }
    public function validate():void{
        if (!$this->getInput('translationKey') || !$this->getInput('translationValue') || !$this->getInput('languageCode')){
            throw new \Exception('missing required fields [translationKey*,translationValue*,languageCode*,groupName,countryCode ]');
        }
    }
    public function process(): static
    {
        $this->validate();
        $this->createNewTranslationRecord();
        return $this;
    }

    private function createNewTranslationRecord()
    {
        $newEntity = $this->translationRepository->createEntity();
        $newEntity->setLanguageCode($this->getInput('languageCode'));
        $newEntity->setTranslationKey(trim(strtolower($this->getInput('translationKey'))));
        $newEntity->setTranslationValue($this->getInput('translationValue'));
        $newEntity->setTranslationGroupName($this->getInput('groupName')??'');
        $newEntity->setCountryCode($this->getInput('countryCode')??'');

        if ($this->translationRepository->saveEntity($newEntity)){
            $this->setOutput('newEntity',$newEntity);
        }
    }
}