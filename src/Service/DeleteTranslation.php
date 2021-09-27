<?php

namespace Jawabkom\Backend\Module\Translation\Service;

use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Backend\Module\Translation\Trait\GetTranslationTrait;
use Jawabkom\Standard\Abstract\AbstractService;
use Jawabkom\Standard\Contract\IDependencyInjector;

class DeleteTranslation extends AbstractService
{

    use GetTranslationTrait;

    protected ITranslationRepository $translationRepository;

    public function __construct(IDependencyInjector $di, ITranslationRepository $translationRepository)
    {
        parent::__construct($di);
        $this->translationRepository = $translationRepository;
    }

    public function process(): static
    {
        $filtersInput = $this->getInput('filters', []);
        $this->validateFilters($filtersInput);
        $compositeAndFilter = $this->buildCompositeFilterObject($filtersInput);
        $records = $this->translationRepository->getByFilters($compositeAndFilter);
        $recordsDeleteStatus = $this->deleteByArray($records);
        $this->setOutput('status', $recordsDeleteStatus);
        return $this;
    }

    /**
     * @param array $entities
     */
    private function deleteByArray(iterable $entities): array
    {
        $status = [
            'deleted' => 0,
            'failed' => 0
        ];
            foreach ($entities as $entity) {
                if ($this->translationRepository->deleteEntity($entity)) {
                    $status['deleted']++;
                } else {
                    $status['failed']++;
                }
            }
        return $status;
    }
}
