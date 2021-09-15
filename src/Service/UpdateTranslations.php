<?php

namespace Jawabkom\Backend\Module\Translation\Service;


use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Backend\Module\Translation\Trait\GetTranslationTrait;
use Jawabkom\Standard\Abstract\AbstractService;
use Jawabkom\Standard\Contract\IDependencyInjector;
use Jawabkom\Standard\Exception\MethodItNotExistsException;
use Jawabkom\Standard\Exception\MissingRequiredInputException;
use Jawabkom\Standard\Exception\NotFoundException;

class UpdateTranslations extends AbstractService
{
    use GetTranslationTrait;
    protected ITranslationRepository $translationRepository;

    /**
     * @param ITranslationRepository $translationRepository
     */
    public function __construct(IDependencyInjector $di, ITranslationRepository $translationRepository)
    {
        parent::__construct($di);
        $this->translationRepository = $translationRepository;
    }

    public function process(): static
    {
        $filtersInput        = $this->getInput('filters', []);
        $newValue            = $this->getInput('newValue');
        $this->validateFilters($filtersInput);
        $compositeAndFilter  = $this->buildCompositeFilterObject($filtersInput);
        $records             = $this->translationRepository->getByFilters($compositeAndFilter);
        $status              = $this->translationRepository->updateEntity($records[0],$newValue);
        $this->setOutput('status',$status);
        return $this;
      }
}