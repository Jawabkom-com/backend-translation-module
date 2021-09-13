<?php

namespace Jawabkom\Backend\Module\Translation\Test\Classes\Composite;

use Jawabkom\Standard\Contract\IFilter;

class Filter extends AbstractFilter
{
    protected string $operationType ='=';
    public function toArray(): array
    {
       return array($this->getName()=>[$this->getOperation()=>$this->getValue()]);
    }

}