<?php

namespace Jawabkom\Backend\Module\Translation\Test\Classes\Composite;

use Jawabkom\Standard\Contract\IAbstractFilter;
use Jawabkom\Standard\Contract\IOrderByFilterComposite;

class OrderByComposite implements IOrderByFilterComposite
{

    protected array $child = [];

    public function toArray(): array
    {
       return $this->child->toArray();
    }

    public function addChild(IAbstractFilter $filter): static
    {
       $this->child['orderBy'] = $filter;
       return $this;
    }

    public function getChildren(): array
    {
       return $this->child;
    }
}