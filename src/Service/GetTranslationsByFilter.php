<?php

namespace Jawabkom\Backend\Module\Translation\Service;

use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Backend\Module\Translation\Exception\FilterNameDoesNotExistsException;
use Jawabkom\Standard\Abstract\AbstractService;
use Jawabkom\Standard\Contract\IAndFilterComposite;
use Jawabkom\Standard\Contract\IDependencyInjector;
use Jawabkom\Standard\Contract\IFilter;
use Jawabkom\Standard\Contract\IOrFilterComposite;
use Jawabkom\Standard\Exception\MethodItNotExistsException;
use Jawabkom\Standard\Exception\MissingRequiredInputException;
use Jawabkom\Standard\Exception\NotFoundException;
use phpDocumentor\Reflection\Types\Object_;

class GetTranslationsByFilter extends AbstractService
{
    protected ITranslationRepository $translationRepository;
    protected $filterNames = ['groupName', 'languageCode', 'countryCode', 'key', 'value'];

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
        $page = $this->getInput('page', 1);
        $perPage = $this->getInput('perPage', 0);
        $filtersInput = $this->getInput('filters', []);
        $this->validateFilters($filtersInput);
        $compositeAndFilter = $this->buildCompositeFilterObject($filtersInput);

        $this->setOutput('translations', $this->translationRepository->getByFilters($compositeAndFilter, $page, $perPage));
        return $this;
    }

    //
    // LEVEL 1
    //
    protected function buildCompositeFilterObject(array $filtersInput): IAndFilterComposite
    {
        /**@var $compositeAndFilter IAndFilterComposite */
        $compositeAndFilter = $this->di->make(IAndFilterComposite::class);
        foreach ($filtersInput as $filterName => $filterValue) {
            if (in_array($filterName, $this->filterNames)) {
                /**@var $filterObj IFilter */
                $filterObj = $this->di->make(IFilter::class);
                $compositeAndFilter->addChild($filterObj->setName($filterName)->setValue($filterValue));
            }
        }
        return $compositeAndFilter;
    }

    protected function validateFilters(array $filtersInput)
    {
        foreach($filtersInput as $filterName => $filterValue) {
            if(!in_array($filterName, $this->filterNames)) {
                throw new FilterNameDoesNotExistsException("Filter name [{$filterName}]");
            }
        }
    }

}