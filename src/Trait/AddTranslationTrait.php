<?php

namespace Jawabkom\Backend\Module\Translation\Trait;

use Jawabkom\Standard\Exception\InputLengthException;
use Jawabkom\Standard\Exception\MissingRequiredInputException;

trait AddTranslationTrait
{

    protected function validateSingleTranslationInput(array $record)
    {
        $this->assertAllRequiredFieldsAreNotEmpty($record);
        $this->assertLanguageInputLength($record['language_code'] ?? '');
        $this->assertCountryCodeLength($record['country_code'] ?? '');
    }

    protected function assertAllRequiredFieldsAreNotEmpty(array $record): void
    {
        if (empty($record['language_code']) ||
            empty($record['key']) ||
            empty($record['value'])) {
            throw new MissingRequiredInputException('missing required fields [key*,value*,language_code*,group_name,country_code ]');
        }
    }

    protected function assertLanguageInputLength(string $languageCode): void
    {
        if (strlen(trim($languageCode)) != 2) {
            throw new InputLengthException('language_code must be 2 characters length');
        }
    }

    protected function assertCountryCodeLength(string $countryCode): void
    {
        if (!empty($countryCode) && strlen(trim($countryCode)) != 2) {
            throw new InputLengthException('country_code must be 2 characters length');
        }
    }

    protected function filterSingleTranslationInput(mixed $translationInput): array
    {
        return [
            'key' => trim(strtolower($translationInput['key'])),
            'country_code' => trim(strtoupper($translationInput['country_code'] ?? '')),
            'language_code' => trim(strtolower($translationInput['language_code'])),
            'value' => $translationInput['value'],
            'group_name' => trim(strtolower($translationInput['group_name'] ?? '')),
        ];
    }

}
