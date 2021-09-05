<?php

namespace Jawabkom\Backend\Module\Translation\Test\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jawabkom\Backend\Module\Translation\Contract\ITranslationEntity;
use Jawabkom\Backend\Module\Translation\Service\AddNewTranslation;
use Jawabkom\Backend\Module\Translation\Test\AbstractTestCase;
use Jawabkom\Standard\Exception\MissingRequiredInputException;

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

        $newEntity =  $this->addNewTrans->input('languageCode',$languageCode)
                          ->input('countryCode',$countryCode)
                          ->input('groupName',$groupName)
                          ->input('translationKey',$key)
                          ->input('translationValue',$value)
                          ->process()
                          ->output('newEntity');
        $this->assertInstanceOf(ITranslationEntity::class,$newEntity);
    }

    public function testCreateNewTransWithRequiredFieldOnly(){
        $languageCode = 'en';
        $key          = 'projectName';
        $value        = 'translationPackage';
        $result = $this->addNewTrans->input('languageCode',$languageCode)
                          ->input('translationKey',$key)
                          ->input('translationValue',$value)
                          ->process()->output('newEntity');
        $this->assertInstanceOf(ITranslationEntity::class,$result);

    }

    public function testCreateNewTransWithKeyMissing(){

        $countryCode  = 'ps';
        $languageCode = 'en';
        $groupName    = 'admin';
        $value        = 'translationPackage';

        $this->expectException(MissingRequiredInputException::class);
        $this->addNewTrans->input('languageCode',$languageCode)
                           ->input('countryCode',$countryCode)
                           ->input('groupName',$groupName)
                           ->input('translationValue',$value)
                           ->process();
     }

    public function testCreateNewTransWIthValueMissing(){
        $countryCode  = 'ps';
        $languageCode = 'en';
        $groupName    = 'admin';
        $key          = 'projectName';

        $this->expectException(MissingRequiredInputException::class);
        $this->addNewTrans->input('languageCode',$languageCode)
                          ->input('countryCode',$countryCode)
                          ->input('groupName',$groupName)
                          ->input('translationKey',$key)
                          ->process();
    }

    public function testTrimKey(){
        $countryCode  = 'ps';
        $languageCode = 'en';
        $groupName    = 'admin';
        $key          = 'ProjectName';
        $value        = 'translationPackage';
        $newEntity = $this->addNewTrans->input('languageCode',$languageCode)
                           ->input('countryCode',$countryCode)
                           ->input('groupName',$groupName)
                           ->input('translationKey',$key)
                           ->input('translationValue',$value)
                           ->process()
                           ->output('newEntity');
        $this->assertInstanceOf(ITranslationEntity::class,$newEntity);
        $this->assertEquals(strtolower($key), $newEntity->getTranslationKey());
    }
}