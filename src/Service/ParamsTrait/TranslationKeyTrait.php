<?php

namespace Jawabkom\Backend\Module\Translation\Service\ParamsTrait;

trait TranslationKeyTrait
{
    private string $translationKey;
    /**
     * @param string $translationKey
     * @return $this
     */
    public function setTranslationKey(string $translationKey):static
    {
        $this->translationKey = trim(strtolower($translationKey));
        return $this;
    }
}