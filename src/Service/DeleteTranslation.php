<?php

namespace Jawabkom\Backend\Module\Translation\Service;

use Jawabkom\Backend\Module\Translation\Test\Classes\TranslationRepository;
use Jawabkom\Standard\Abstract\AbstractService;
use Jawabkom\Standard\Exception\MissingRequiredInputException;
use Jawabkom\Standard\Exception\NotFoundException;

class DeleteTranslation extends AbstractService {

    private TranslationRepository $translationRepository;

    public function __construct(TranslationRepository $translationRepository)
    {

        $this->translationRepository = $translationRepository;
    }

    public function process(): static
    {
     $methodName = 'handler'.ucwords($this->getInput('method'));
       $this->{$methodName}();
       return $this;
    }

    private function validate($key)
    {
        if (empty($key))
            throw new MissingRequiredInputException("Translation::{$key} is required");

    }

    public function byTransKey(string $transKey):static
    {
        $this->validate($transKey);
        $this->inputs(['method'=>'byTransKey','key'=>$transKey]);
         return $this;
    }
    public function truncateTranslation():static{
        $this->input('method','truncateTranslation');
        return $this;
     }
    /***
    #Handler
     ***/
    private function handlerTruncateTranslation():void{
        $record  = $this->translationRepository->truncateTranslations();
        $this->setOutput('status',$record);
    }

    private function handlerByTransKey(){

        $record = $this->translationRepository->findByKey($this->getInput('key'));
        if (!$record){
            throw new NotFoundException('Translation Key is not exists');
        }
        $this->setOutput('status',$record->deleteEntity());

    }
}