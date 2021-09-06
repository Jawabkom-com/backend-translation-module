<?php

namespace Jawabkom\Backend\Module\Translation\Test\Unit;

use Jawabkom\Backend\Module\Translation\Contract\ITranslationEntity;
use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Backend\Module\Translation\Service\AddNewTranslation;
use Jawabkom\Backend\Module\Translation\Service\DeleteTranslation;
use Jawabkom\Backend\Module\Translation\Test\AbstractTestCase;
use Jawabkom\Standard\Exception\NotFoundException;

class DeleteTranslationTest extends AbstractTestCase
{
    private mixed $deleteTransService;
    private mixed $addTransService;

    public function setUp(): void
    {
        parent::setUp();
        $this->deleteTransService = $this->app->make(DeleteTranslation::class);
        $this->addTransService    = $this->app->make(AddNewTranslation::class);
    }

    //test delete trans by key
    public function testDeleteByKey(){
        $countryCode  = 'ps';
        $languageCode = 'en';
        $groupName    = 'admin';
        $key          = 'projectName';
        $value        = 'translationPackage';

        $newEntity =  $this->addTransService->input('languageCode',$languageCode)
                        ->input('countryCode',$countryCode)
                        ->input('groupName',$groupName)
                        ->input('translationKey',$key)
                        ->input('translationValue',$value)
                        ->process()
                        ->output('newEntity');

        $deleteStatus = $this->deleteTransService->byTransKey($newEntity->getTranslationKey())
                             ->process()
                             ->output('status');
        $this->assertDatabaseMissing('translations',[
            'key'=>$newEntity->getTranslationKey()
        ]);
        $this->assertTrue($deleteStatus);
    }
    //test delete key is not exits
    public function testDeleteByKeyNotExits(){

        $this->expectException(NotFoundException::class);
        $this->deleteTransService->byTransKey('JAWAB-TRANSLATE')
             ->process()
             ->output('status');
    }

    //test delete trans all
    public function testDeleteAllTrans(){
        $countryCode  = 'ps';
        $languageCode = 'en';
        $groupName    = 'admin';
        $key          = 'projectName';
        $value        = 'translationPackage';

        $newEntity =  $this->addTransService->input('languageCode',$languageCode)
            ->input('countryCode',$countryCode)
            ->input('groupName',$groupName)
            ->input('translationKey',$key)
            ->input('translationValue',$value)
            ->process()
            ->output('newEntity');
        $this->assertInstanceOf(ITranslationEntity::class,$newEntity);

        $this->deleteTransService->truncateTranslation()->process();
    }
    //test delete trans by group
    //test delete trans by language code
}