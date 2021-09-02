<?php

namespace Jawabkom\Backend\Module\Translation\Service\ParamsTrait;

trait TranslationValueTrait
{

    private string $translationValue;
    /**
     * @param string $translationValue
     * @return $this
     */

    public function setTranslationValue(string $translationValue):static{
        $this->translationValue = $translationValue;
        return $this;
    }
}