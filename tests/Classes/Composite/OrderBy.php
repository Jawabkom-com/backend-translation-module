<?php

namespace Jawabkom\Backend\Module\Translation\Test\Classes\Composite;

use Jawabkom\Standard\Contract\IOrderBy;

class OrderBy extends AbstractFilter implements IOrderBy
{

    public function toArray(): array
    {
        return array($this->getName()=>$this->getValue());
    }
}