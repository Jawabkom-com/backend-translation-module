<?php

namespace Jawabkom\Backend\Module\Translation\Service\ParamsTrait;

trait LanguageCodeTrait
{
    private string $languageCode;
    /**
     * @param string $languageCode
     * @return $this
     */
    public function setLanguageCode(string $languageCode):static{
        $this->languageCode = $languageCode;
        return $this;
    }
}