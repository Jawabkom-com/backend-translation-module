<?php

namespace Jawabkom\Backend\Module\Translation\Test\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jawabkom\Backend\Module\Translation\Contract\ITranslationEntity;
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

        $newEntity =  $this->addNewTrans->input('languageCode',$languageCode)
                          ->input('countryCode',$countryCode)
                          ->input('groupName',$groupName)
                          ->input('translationKey',$key)
                          ->input('translationValue',$value)
                          ->process()
                          ->output('newEntity');
        $this->assertInstanceOf(ITranslationEntity::class,$newEntity);
    }

    public function testCreateNewTransWIthRequiredFieldOnly(){
        $languageCode = 'en';
        $key          = 'projectName';
        $value        = 'translationPackage';
        $result = $this->addNewTrans->input('languageCode',$languageCode)
                          ->input('translationKey',$key)
                          ->input('translationValue',$value)
                          ->process()->output('newEntity');
        $this->assertInstanceOf(ITranslationEntity::class,$result);

    }

    public function testCreateNewTransWIthKeyMissing(){

        $countryCode  = 'ps';
        $languageCode = 'en';
        $groupName    = 'admin';
        $value        = 'translationPackage';

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('missing required fields [translationKey*,translationValue*,languageCode*,groupName,countryCode ]');
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

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('missing required fields [translationKey*,translationValue*,languageCode*,groupName,countryCode ]');
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

       $newTrans =$newEntity->toArray();
       $this->assertEquals(strtolower($key),$newTrans['key']);
    }
}