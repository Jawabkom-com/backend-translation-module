<?php

namespace Jawabkom\Standard\Contract;

interface IFilter extends IAbstractFilter
{
    public function setName(string $filterName):static;
    public function getName():string;

    public function setValue(mixed $value):static;
    public function getValue():mixed;

    public function setOperation(string $operation):static;
    public function getOperation():string;
}