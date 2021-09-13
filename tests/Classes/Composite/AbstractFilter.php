<?php

namespace Jawabkom\Backend\Module\Translation\Test\Classes\Composite;

use Jawabkom\Standard\Contract\IFilter;

abstract class AbstractFilter implements IFilter
{
    protected string $filedName;
    protected string $filedValue;
    protected string $operationType;

   abstract  public function toArray(): array;

    public function setName(string $filterName): static
    {
        $this->filedName = $filterName;
        return $this;
    }

    public function getName(): string
    {
        return  $this->filedName;
    }

    public function setValue(mixed $value): static
    {
        $this->filedValue = $value;
        return $this;
    }

    public function getValue(): mixed
    {
        return $this->filedValue;
    }

    public function setOperation(string $operation): static
    {
        $this->operationType = $operation;
        return $this;
    }

    public function getOperation(): string
    {
        return  $this->operationType;
    }

}