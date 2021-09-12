<?php

namespace Jawabkom\Backend\Module\Translation\Service;

use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Standard\Abstract\AbstractService;
use Jawabkom\Standard\Exception\MethodItNotExistsException;
use Jawabkom\Standard\Exception\MissingRequiredInputException;

class GetTranslations extends AbstractService
{
    private ITranslationRepository $translationRepository;

    public function __construct(ITranslationRepository $translationRepository)
    {

        $this->translationRepository = $translationRepository;
    }

    public function process(): static
    {
        $methodName = 'handler'.ucwords($this->getInput('method'));

        if (!method_exists($this,$methodName)){
            throw new MethodItNotExistsException("ERROR::[$methodName] Method not exists");
        }
        $this->{$methodName}();
        return $this;

    }

    public function listTrnasltion(){
        $this->setOutput('list',$this->translationRepository->allTranslations());
        return $this;
    }

    public function byGroupName(string $groupName){
        $this->validate($groupName);
         $this->inputs(['method'=>'byGroupName','groupName'=>$groupName]);
         return $this;
    }

    public function byLocal(string $local){
        $this->validate($local);
         $this->inputs(['method'=>'byLocal','local'=>$local]);
         return $this;
    }

    public function byKey(string $key){
        $this->validate($key);
         $this->inputs(['method'=>'byKey','key'=>$key]);
         return $this;
    }

    public function byValue(string $value){
        $this->validate($value);
         $this->inputs(['method'=>'byValue','value'=>$value]);
         return $this;
    }
    public function filterBy(string|null $key='', string|null $value='',
                             string|null $local='',string|null $groupName='',
                             string|null $countryCode='',bool $paginate=true,
                             int $perPage=15){
        $this->inputs([
            'method'=>'filterBy',
            'key'=>$key,'value'=>$value,
            'local'=>$local,'groupName'=>$groupName,
            'countryCode'=>$countryCode,'paginate'=>$paginate,'perPage'=>$perPage
        ]);
        return $this;
    }

    private function validate($key)
    {
        if (empty($key))
            throw new MissingRequiredInputException("Translation::{$key} is required");

    }

    #handler
    private function handlerByGroupName(){
         $groupName =  $this->getInput('groupName');
        $records = $this->translationRepository->getByGroup($groupName);
        $this->setOutput('list',$records);
        return $this;
    }
    private function handlerByLocal(){
         $local =  $this->getInput('local');
        $records = $this->translationRepository->getByLocal($local);
        $this->setOutput('list',$records);
        return $this;
    }
    private function handlerByKey(){
        $key    =  $this->getInput('key');
        $record = $this->translationRepository->findByKey($key);
        $this->setOutput('list',$record);
        return $this;
    }
    private function handlerByValue(){
        $value    =  $this->getInput('value');
        $record = $this->translationRepository->findByValue($value);
        $this->setOutput('list',$record);
        return $this;
    }

    private function handlerFilterBy(){
        $key= $this->getInput('key');
        $value= $this->getInput('value');
        $local= $this->getInput('local');
        $groupName= $this->getInput('groupName');
        $countryCode= $this->getInput('countryCode');
        $paginate= $this->getInput('paginate');
        $perPage= $this->getInput('perPage');
        //get
        $result = $this->translationRepository->getFilter($key,$value,$local,$groupName,strtoupper($countryCode),$paginate,$perPage);
        $this->setOutput('list',$result);
        return $this;
    }
}