<?php

namespace Jawabkom\Backend\Module\Translation\Service;

use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Backend\Module\Translation\Trait\GetTranslationTrait;
use Jawabkom\Standard\Abstract\AbstractService;
use Jawabkom\Standard\Contract\IDependencyInjector;
use Jawabkom\Standard\Contract\IOrderByFilterComposite;

class GetTranslationsByFilter extends AbstractService
{
    use GetTranslationTrait;

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
        $page = $this->getInput('page', 1);
        $perPage = $this->getInput('perPage', 0);
        $filtersInput = $this->getInput('filters', []);
        $orderByInput = $this->getInput('orderBy', []);

        $this->validateFilters($filtersInput);
        $compositeAndFilter = $this->buildCompositeFilterObject($filtersInput);
        $orderBy = $this->buildCompositeOrderByObject($orderByInput);

        $this->setOutput('translations', $this->translationRepository->getByFilters($compositeAndFilter, $orderBy, $page, $perPage));
        return $this;
    }

}