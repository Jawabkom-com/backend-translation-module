<?php

namespace Jawabkom\Backend\Module\Translation\Service\ParamsTrait;

trait TranslationGroupNameTrait
{
    private string $translationGroupName;
    /**
     * @param string $translationGroupName
     * @return $this
     */
    public function setTranslationGroupName(string $translationGroupName=''):static{
        $this->translationGroupName = $translationGroupName;
        return $this;
    }
}