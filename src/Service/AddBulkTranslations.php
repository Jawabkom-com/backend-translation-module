<?php

namespace Jawabkom\Backend\Module\Translation\Service;

use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Standard\Abstract\AbstractService;
use Jawabkom\Standard\Exception\MissingRequiredInputException;

class AddBulkTranslations extends AbstractService {

   private ITranslationRepository $translationRepository;

    public function __construct(ITranslationRepository $translationRepository)
    {

        $this->translationRepository = $translationRepository;
    }

    public function process(): static
    {
      $this->validate();
      $this->addBulkTranslation();
      return $this;

    }

    private function validate()
    {
        foreach ($this->getInputs() as $inx => $record){
           if(empty($record['language_code']) ||
              empty($record['key']) ||
              empty($record['value']))
           {
               throw new MissingRequiredInputException('missing required fields [key*,value*,language_code*,group_name,country_code ]');
           }
        }
    }

    private function addBulkTranslation()
    {
        $translation = $this->checkFormat();
        $insertStatus = $this->translationRepository->insertBulk($translation);
        $this->setOutput('status',$insertStatus);
    }

    /**
     * @return array
     */
    private function checkFormat(): array
    {
       return array_map(function ($ele) {
            $ele['key'] = strtolower($ele['key']);
            $ele['country_code'] = empty($ele['country_code']) ? '' : strtoupper($ele['country_code']);
            return $ele;
        }, $this->getInputs());
    }

}