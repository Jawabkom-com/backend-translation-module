<?php

namespace Jawabkom\Backend\Module\Translation\Test\Classes\Composite\Filters;

use Jawabkom\Standard\Contract\IAbstractFilter;
use Jawabkom\Standard\Contract\IAndFilterComposite;
use Jawabkom\Standard\Contract\IFilterComposite;

class AbstractFilterComposite implements IFilterComposite
{
    protected array $child =[];
    public function toArray(): array
    {
     return $this->child->toArray();
    }

    public function addChild(IAbstractFilter $filter): static
    {
        $this->child[] = $filter;
        return $this;
    }

    public function getChildren(): array
    {
       return $this->child;
    }
}