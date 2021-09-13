<?php

namespace Jawabkom\Backend\Module\Translation\Service;


use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Standard\Abstract\AbstractService;
use Jawabkom\Standard\Contract\IDependencyInjector;
use Jawabkom\Standard\Exception\MethodItNotExistsException;
use Jawabkom\Standard\Exception\MissingRequiredInputException;
use Jawabkom\Standard\Exception\NotFoundException;

class UpdateTranslations extends AbstractService
{
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
        $methodName = 'handler'.ucwords($this->getInput('method'));
        if (!method_exists($this,$methodName)){
            throw new MethodItNotExistsException("ERROR::[$methodName] Method not exists");
        }
        $this->{$methodName}();
        return $this;

    }

    public function byKey(string $key,array $newValues){
        $this->validate($newValues);
        $this->validate($key);
        $this->inputs(['method'=>'byKey','key'=>$key,'newValues'=>$newValues]);
        return $this;
     }

    private function validate($transKey)
    {
        if (empty($transKey))
            throw new MissingRequiredInputException("Translation::{$transKey} is required");
    }

    #handler
    public function handlerByKey(){
      $key       = $this->getInput('key');
      $newValues = $this->getInput('newValues');

      $record = $this->translationRepository->findByKey(strtolower($key));
        if (!$record){
            throw new NotFoundException("Translation:: {$key} is not found");
        }
        $this->setOutput('status',  $record->updateByKey($newValues));
    }

}