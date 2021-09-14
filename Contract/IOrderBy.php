<?php

namespace Jawabkom\Standard\Contract;

interface IOrderBy
{
    public function setFieldName(string $fieldName):static;
    public function getFieldName():string;

    public function setIsDescending(bool $isDescending):static;
    public function getIsDescending():bool;
}