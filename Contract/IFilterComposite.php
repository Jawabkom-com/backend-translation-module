<?php

namespace Jawabkom\Standard\Contract;

interface IFilterComposite extends IAbstractFilter
{
    public function addChild(IAbstractFilter $filter):static;

    /**
     * @return IAbstractFilter[]
     */
    public function getChildren():array;
}