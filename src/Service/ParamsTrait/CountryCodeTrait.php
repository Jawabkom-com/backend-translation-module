<?php

namespace Jawabkom\Backend\Module\Translation\Service\ParamsTrait;

trait CountryCodeTrait
{
    private string $countryCode;
    /**
     * @param string $countryCode
     * @return $this
     */
    public function setCountryCode(string $countryCode=''):static{
        $this->countryCode = $countryCode;
        return $this;
    }
}