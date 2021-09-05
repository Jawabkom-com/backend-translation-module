<?php

namespace Jawabkom\Backend\Module\Translation\Test\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jawabkom\Backend\Module\Translation\Service\AddNewTranslation;
use Jawabkom\Backend\Module\Translation\Test\AbstractTestCase;

class AddNewTranslationTest extends AbstractTestCase
{
    protected AddNewTranslation $addNewTrans;
    private string $countryCode;
    private string $languageCode;
    private string $groupName;
    private string $key;
    private string $value;

    public function setUp(): void
    {
        parent::setUp();
        $this->addNewTrans = $this->app->make(AddNewTranslation::class);
    }

    use RefreshDatabase;
    public function testCreateTranslation(){
        $countryCode  = 'ps';
        $languageCode = 'en';
        $groupName    = 'admin';
        $key          = 'projectName';
        $value        = 'translationPackage';

        $this->addNewTrans->setCountryCode($countryCode)
                          ->setLanguageCode($languageCode)
                          ->setTranslationGroupName($groupName)
                          ->setTranslationKey($key)
                          ->setTranslationValue($value)
                          ->process();

        $result     = $this->addNewTrans->output('created');
        $this->assertTrue($result);
    }

    public function testCreateNewTransWIthRequiredFieldOnly(){
        $languageCode = 'en';
        $key          = 'projectName';
        $value        = 'translationPackage';
        $this->addNewTrans->setCountryCode('')
                          ->setLanguageCode($languageCode)
                          ->setTranslationGroupName('')
                          ->setTranslationKey($key)
                          ->setTranslationValue($value)
                          ->process();
        $result     = $this->addNewTrans->output('created');
        $this->assertTrue($result);

    }

    public function testCreateNewTransWIthKeyMissing(){

        $countryCode  = 'ps';
        $languageCode = 'en';
        $groupName    = 'admin';
        $value        = 'translationPackage';

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('this is required filed');
        $this->addNewTrans->setCountryCode($countryCode)
                          ->setLanguageCode($languageCode)
                          ->setTranslationGroupName($groupName)
                          ->setTranslationKey('')
                          ->setTranslationValue($value)
                          ->process();
     }

    public function testCreateNewTransWIthValueMissing(){
        $countryCode  = 'ps';
        $languageCode = 'en';
        $groupName    = 'admin';
        $key          = 'projectName';

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('this is required filed');
        $this->addNewTrans->setCountryCode($countryCode)
                          ->setLanguageCode($languageCode)
                          ->setTranslationGroupName($groupName)
                          ->setTranslationKey($key)
                          ->setTranslationValue('')
                          ->process();
    }

    public function testTrimKey(){
        $countryCode  = 'ps';
        $languageCode = 'en';
        $groupName    = 'admin';
        $key          = 'ProjectName';
        $value        = 'translationPackage';
        $this->addNewTrans->setCountryCode($countryCode)
            ->setLanguageCode($languageCode)
            ->setTranslationGroupName($groupName)
            ->setTranslationKey($key)
            ->setTranslationValue($value)
            ->process();
        $result     = $this->addNewTrans->output('created');
        $this->assertTrue($result);

       $newTrans = $this->addNewTrans->output('newEntity');
       $this->assertEquals(strtolower($key),$newTrans['key']);
    }
}