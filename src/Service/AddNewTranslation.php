<?php

namespace Jawabkom\Backend\Module\Translation\Service;

use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Backend\Module\Translation\Trait\AddTranslationTrait;
use Jawabkom\Standard\Abstract\AbstractService;
use Jawabkom\Standard\Contract\IDependencyInjector;
use Jawabkom\Standard\Exception\InputLengthException;
use Jawabkom\Standard\Exception\MissingRequiredInputException;

class AddNewTranslation extends AbstractService {

    use AddTranslationTrait;

    protected ITranslationRepository $translationRepository;

    public function __construct(IDependencyInjector $di, ITranslationRepository $translationRepository)
    {
        parent::__construct($di);
        $this->translationRepository = $translationRepository;
    }


    //
    // LEVEL 0
    //
    public function process(): static
    {
        $this->validateInputs();
        $this->createNewTranslationRecord();
        return $this;
    }


    //
    // LEVEL 1
    //
    public function validateInputs():void{
        $this->validateSingleTranslationInput($this->getInputs());
    }


    private function createNewTranslationRecord()
    {
        $filterInputs = $this->filterInputFormat();
        $newEntity = $this->translationRepository->createEntity();
        $newEntity->setLanguageCode($filterInputs['language_code']);
        $newEntity->setTranslationKey($filterInputs['key']);
        $newEntity->setTranslationValue($filterInputs['value']);
        $newEntity->setTranslationGroupName($filterInputs['group_name']??'');
        $newEntity->setCountryCode(trim(strtoupper($filterInputs['country_code']??'')));

        if ($this->translationRepository->saveEntity($newEntity)){
            $this->setOutput('newEntity',$newEntity);
        }
    }


    //
    // LEVEL 2
    //
    protected function filterInputFormat() :array {
        return $this->filterSingleTranslationInput($this->getInputs());
    }


}
