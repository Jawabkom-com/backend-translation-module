<?php

namespace Jawabkom\Backend\Module\Translation\Service;

use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Standard\Abstract\AbstractService;
use Jawabkom\Standard\Exception\InputLengthException;
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
           if (strlen(trim($record['language_code']))<2){
                throw new InputLengthException('language_code length must at least 2 character');
           }
           if (!empty($record['country_code']) && strlen(trim($record['country_code']))<2){
               throw new InputLengthException('country_code length must at least 2 character');
           }
        }
    }

    private function addBulkTranslation()
    {
        $filterInputs = $this->filterInputFormat();
        $insertStatus = $this->translationRepository->insertBulk($filterInputs);
        $this->setOutput('status',$insertStatus);
    }

    /**
     * @return array
     */
    private function filterInputFormat(): array
    {
        $filteredInput =[];
        foreach ($this->getInputs() as $ele){
             $filteredInput[] =[
                  'key'            => trim(strtolower($ele['key'])),
                  'country_code'   => trim(strtoupper($ele['country_code']??'')),
                  'language_code'  => trim(strtolower($ele['language_code'])),
                  'value'          => $ele['value'],
                  'group_name'     => trim(strtolower($ele['group_name']??'')),
              ];
        }
        return $filteredInput;
    }

}
