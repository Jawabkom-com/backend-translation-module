<?php

namespace Jawabkom\Backend\Module\Translation\Service;

use Jawabkom\Backend\Module\Translation\Test\Classes\TranslationRepository;
use Jawabkom\Standard\Abstract\AbstractService;
use Jawabkom\Standard\Exception\MethodNotExistsException;
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
     if (!method_exists($this,$methodName)){
        throw new MethodNotExistsException("ERROR::[$methodName] Method not exists");
     }
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
    public function byTransGroup(string $transGroup):static{
        $this->validate($transGroup);
        $this->inputs(['method'=>'byTransGroup','groupName'=>$transGroup]);
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
        $key =$this->getInput('key');
        $record = $this->translationRepository->findByKey($key);
        if (!$record){
            throw new NotFoundException("Translation:: {$key} is not exists");
        }
        $this->setOutput('status',$record->deleteEntity());
    }

    private function handlerByTransGroup(){
        $groupName =$this->getInput('groupName');
        $record = $this->translationRepository->findByGroup($groupName);
        if (!$record){
            throw new NotFoundException("Translation:: {$groupName} is not exists");
        }
         $this->setOutput('status',$record->deleteEntity());
    }
}