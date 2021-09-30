<?php

namespace Jawabkom\Backend\Module\Translation\Service;

use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Backend\Module\Translation\Trait\AddTranslationTrait;
use Jawabkom\Standard\Abstract\AbstractService;
use Jawabkom\Standard\Contract\IDependencyInjector;
use Jawabkom\Standard\Exception\MissingRequiredInputException;

class GetTranslationsByKey extends AbstractService {

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
        $this->validate();
        $this->getByKey();
        return $this;
    }


    //
    // LEVEL 1
    //
    protected function getByKey()
    {
        $filteredInput = $this->filterSingleTranslationInput($this->getInputs());
        $entity = $this->translationRepository->getByKey($filteredInput['key'], $filteredInput['group_name'], $filteredInput['language_code'], $filteredInput['country_code']);
        $this->setOutput('entity', $entity);
    }

    private function validate(): void
    {
        if (empty($this->getInput('key'))) {
            throw new MissingRequiredInputException('missing required fields [key*]');
        }
        if ($countryCode = $this->getInput('country_code')) {
            $this->assertCountryCodeLength($countryCode);
        }
        if ($languageCode = $this->getInput('language_code')) {
            $this->assertLanguageInputLength($languageCode);
        }
    }

}
