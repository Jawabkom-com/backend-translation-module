<?php

namespace Jawabkom\Backend\Module\Translation\Test\Classes\Composite;

use Jawabkom\Standard\Contract\IOrderBy;

class OrderBy implements IOrderBy
{

    private string $fieldName;
    private bool $isDescending = true;

    public function setFieldName(string $fieldName): static
    {
        $this->fieldName = $fieldName;
        return $this;
    }

    public function getFieldName(): string
    {
      return $this->fieldName;
    }

    public function setIsDescending(bool $isDescending): static
    {
       $this->isDescending = $isDescending;
        return $this;
    }

    public function getIsDescending(): bool
    {
     return  $this->isDescending;
    }
}