<?php

namespace Jawabkom\Backend\Module\Translation\Service;

use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Backend\Module\Translation\Trait\AddTranslationTrait;
use Jawabkom\Standard\Abstract\AbstractService;
use Jawabkom\Standard\Contract\IDependencyInjector;

class SaveTranslation extends AbstractService {

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
        $this->saveTranslationRecord();
        return $this;
    }


    //
    // LEVEL 1
    //
    protected function saveTranslationRecord()
    {
        $filteredInput = $this->filterSingleTranslationInput($this->getInputs());
         // check if entity already exists
        $entity = $this->translationRepository->getByKey($filteredInput['key'], $filteredInput['group_name'], $filteredInput['language_code'], $filteredInput['country_code']);
        if(!$entity) {
            $this->setOutput('is_new_entity', true);
            $entity = $this->translationRepository->createEntity();
        } else {
            $this->setOutput('is_new_entity', false);
        }

        $this->fillEntityObjectUsingFilteredInput($entity, $filteredInput);
        if ($this->translationRepository->saveEntity($entity)) {
            $this->setOutput('entity', $entity);
        }
    }

}
