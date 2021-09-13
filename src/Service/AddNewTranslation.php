<?php

namespace Jawabkom\Backend\Module\Translation\Service;

use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Standard\Abstract\AbstractService;
use Jawabkom\Standard\Contract\IDependencyInjector;
use Jawabkom\Standard\Exception\InputLengthException;
use Jawabkom\Standard\Exception\MissingRequiredInputException;

class AddNewTranslation extends AbstractService {

    protected ITranslationRepository $translationRepository;

    public function __construct(IDependencyInjector $di, ITranslationRepository $translationRepository)
    {
        parent::__construct($di);
        $this->translationRepository = $translationRepository;
    }
    public function validate():void{
        if (!$this->getInput('translationKey') || !$this->getInput('translationValue') || !$this->getInput('languageCode')){
            throw new MissingRequiredInputException('missing required fields [translationKey*,translationValue*,languageCode*,groupName,countryCode ]');
        }
        if (strlen(trim($this->getInput('languageCode')))<2){
            throw new InputLengthException('languageCode length must at least 2 character');
        }

        if ($this->getInput('countryCode') && strlen(trim($this->getInput('countryCode')))<2){
            throw new InputLengthException('countryCode length must at least 2 character');
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
        $newEntity->setCountryCode(trim(strtoupper($this->getInput('countryCode')??'')));

        if ($this->translationRepository->saveEntity($newEntity)){
            $this->setOutput('newEntity',$newEntity);
        }
    }
}