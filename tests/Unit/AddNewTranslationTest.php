<?php

namespace Jawabkom\Backend\Module\Translation\Test\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jawabkom\Backend\Module\Translation\Contract\ITranslationEntity;
use Jawabkom\Backend\Module\Translation\Service\SaveTranslation;
use Jawabkom\Backend\Module\Translation\Test\AbstractTestCase;
use Jawabkom\Standard\Exception\InputLengthException;
use Jawabkom\Standard\Exception\MissingRequiredInputException;

class AddNewTranslationTest extends AbstractTestCase
{
    protected SaveTranslation $addNewTrans;
    private string $countryCode;
    private string $languageCode;
    private string $groupName;
    private string $key;
    private string $value;

    public function setUp(): void
    {
        parent::setUp();
        $this->addNewTrans = $this->app->make(SaveTranslation::class);
    }

    use RefreshDatabase;
    public function testCreateTranslation(){
        $countryCode  = 'ps';
        $languageCode = 'en';
        $groupName    = 'admin';
        $key          = 'projectName';
        $value        = 'translationPackage';

        $newEntity =  $this->addNewTrans->input('language_code',$languageCode)
                          ->input('country_code',$countryCode)
                          ->input('group_name',$groupName)
                          ->input('key',$key)
                          ->input('value',$value)
                          ->process()
                          ->output('entity');
        $this->assertInstanceOf(ITranslationEntity::class,$newEntity);
    }

    public function testCreateNewTransWithRequiredFieldOnly(){
        $languageCode = 'en';
        $key          = 'projectName';
        $value        = 'translationPackage';
        $result = $this->addNewTrans->input('language_code',$languageCode)
                          ->input('key',$key)
                          ->input('value',$value)
                          ->process()->output('entity');
        $this->assertInstanceOf(ITranslationEntity::class,$result);

    }

    public function testCreateNewTransWithKeyMissing(){

        $countryCode  = 'ps';
        $languageCode = 'en';
        $groupName    = 'admin';
        $value        = 'translationPackage';

        $this->expectException(MissingRequiredInputException::class);
        $this->addNewTrans->input('language_code',$languageCode)
                           ->input('country_code',$countryCode)
                           ->input('group_name',$groupName)
                           ->input('value',$value)
                           ->process();
     }

    public function testCreateNewTransWIthValueMissing(){
        $countryCode  = 'ps';
        $languageCode = 'en';
        $groupName    = 'admin';
        $key          = 'projectName';

        $this->expectException(MissingRequiredInputException::class);
        $this->addNewTrans->input('language_code',$languageCode)
                          ->input('country_code',$countryCode)
                          ->input('group_name',$groupName)
                          ->input('key',$key)
                          ->process();
    }

    public function testTrimKey(){
        $countryCode  = 'ps';
        $languageCode = 'en';
        $groupName    = 'admin';
        $key          = 'ProjectName';
        $value        = 'translationPackage';
        $newEntity = $this->addNewTrans->input('language_code',$languageCode)
                           ->input('country_code',$countryCode)
                           ->input('group_name',$groupName)
                           ->input('key',$key)
                           ->input('value',$value)
                           ->process()
                           ->output('entity');
        $this->assertInstanceOf(ITranslationEntity::class,$newEntity);
        $this->assertEquals(strtolower($key), $newEntity->getTranslationKey());
    }
    public function testCountryCodeLengthLessThanRequiredLength(){
        $countryCode  = 'p';
        $languageCode = 'en';
        $groupName    = 'admin';
        $key          = 'ProjectName';
        $value        = 'translationPackage';
        $this->expectException(InputLengthException::class);
         $this->addNewTrans->input('language_code',$languageCode)
                           ->input('country_code',$countryCode)
                           ->input('group_name',$groupName)
                           ->input('key',$key)
                           ->input('value',$value)
                           ->process()
                           ->output('entity');
    }

    public function testLanguageCodeInputLengthLessThanRequiredLength(){
        $countryCode  = 'ps';
        $languageCode = 'e';
        $groupName    = 'admin';
        $key          = 'ProjectName';
        $value        = 'translationPackage';
        $this->expectException(InputLengthException::class);
         $this->addNewTrans->input('language_code',$languageCode)
                           ->input('country_code',$countryCode)
                           ->input('group_name',$groupName)
                           ->input('key',$key)
                           ->input('value',$value)
                           ->process()
                           ->output('entity');
    }
}
