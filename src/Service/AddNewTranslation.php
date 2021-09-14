<?php

namespace Jawabkom\Backend\Module\Translation\Service;

use Jawabkom\Backend\Module\Translation\Contract\ITranslationEntity;
use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Backend\Module\Translation\Trait\AddTranslationTrait;
use Jawabkom\Standard\Abstract\AbstractService;
use Jawabkom\Standard\Contract\IDependencyInjector;

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
        $this->validateSingleTranslationInput($this->getInputs());
        $this->createNewTranslationRecord();
        return $this;
    }


    //
    // LEVEL 1
    //
    protected function createNewTranslationRecord()
    {
        $filterInputs = $this->filterSingleTranslationInput($this->getInputs());
        $newEntity = $this->translationRepository->createEntity();
        $this->fillEntityObjectUsingFilteredInput($newEntity, $filterInputs);

        if ($this->translationRepository->saveEntity($newEntity)){
            $this->setOutput('newEntity',$newEntity);
        }
    }

    protected function fillEntityObjectUsingFilteredInput(ITranslationEntity $newEntity, array $filterInputs): void
    {
        $newEntity->setLanguageCode($filterInputs['language_code']);
        $newEntity->setTranslationKey($filterInputs['key']);
        $newEntity->setTranslationValue($filterInputs['value']);
        $newEntity->setTranslationGroupName($filterInputs['group_name'] ?? '');
        $newEntity->setCountryCode(trim(strtoupper($filterInputs['country_code'] ?? '')));
    }

}
