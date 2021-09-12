<?php

namespace Jawabkom\Backend\Module\Translation\Service;

use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Backend\Module\Translation\Trait\AddTranslationTrait;
use Jawabkom\Standard\Abstract\AbstractService;

class AddBulkTranslations extends AbstractService
{

    use AddTranslationTrait;

    protected ITranslationRepository $translationRepository;

    public function __construct(ITranslationRepository $translationRepository)
    {
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
        $filterInputs = $this->filterInputFormat();
        $insertStatus = $this->translationRepository->insertBulk($filterInputs);
        $this->setOutput('status', $insertStatus);
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
