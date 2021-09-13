<?php

namespace Jawabkom\Backend\Module\Translation\Test\Classes\Composite\Filters;

use Jawabkom\Standard\Contract\IAbstractFilter;
use Jawabkom\Standard\Contract\IAndFilterComposite;

class AndFilter implements IAndFilterComposite
{
    protected array $child =[];
    public function toArray(): array
    {
     return $this->child->toArray();
    }

    public function addChild(IAbstractFilter $filter): static
    {
        $this->child['where'] = $filter;
        return $this;
    }

    public function getChildren(): array
    {
       return $this->child;
    }
}