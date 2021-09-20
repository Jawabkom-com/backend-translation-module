<?php

namespace Jawabkom\Backend\Module\Translation\Service;

use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Backend\Module\Translation\Trait\AddTranslationTrait;
use Jawabkom\Standard\Abstract\AbstractService;
use Jawabkom\Standard\Contract\IDependencyInjector;

class SaveBulkTranslations extends AbstractService
{

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
        $this->addBulkTranslation();
        return $this;
    }

    //
    // LEVEL 1
    //
    protected function validateInputs()
    {
        foreach ($this->getInputs() as $record) {
            $this->validateSingleTranslationInput($record);
        }
    }

    protected function addBulkTranslation()
    {
        $filteredInputs = $this->filterInputFormat();
        $status = [
            'created' => 0,
            'updated' => 0,
            'failed' => 0
        ];
        foreach($filteredInputs as $filteredInput) {
            // check if entity already saved
            $isNewEntity = false;
            $entity = $this->translationRepository->getByKey($filteredInput['key'], $filteredInput['group_name'], $filteredInput['language_code'], $filteredInput['country_code']);
            // if not exists then create a new one
            if(!$entity) {
                $isNewEntity = true;
                $entity      = $this->translationRepository->createEntity();
                $this->fillEntityObjectUsingFilteredInput($entity, $filteredInput);
            }

            if($this->translationRepository->saveEntity($entity)) {
                if($isNewEntity) {
                    $status['created']++;
                } else {
                    $status['updated']++;
                }
            } else {
                $status['failed']++;
            }
        }

        $this->setOutput('status', $status);
    }

    //
    // LEVEL 2
    //
    protected function filterInputFormat(): array
    {
        $filteredInput = [];
        foreach ($this->getInputs() as $translationInput) {
            $filteredInput[] = $this->filterSingleTranslationInput($translationInput);
        }
        return $filteredInput;
    }

}
