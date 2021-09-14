<?php

namespace Jawabkom\Backend\Module\Translation\Test\Unit;

use Jawabkom\Backend\Module\Translation\Contract\ITranslationEntity;
use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Backend\Module\Translation\Service\AddBulkTranslations;
use Jawabkom\Backend\Module\Translation\Service\AddNewTranslation;
use Jawabkom\Backend\Module\Translation\Service\DeleteTranslation;
use Jawabkom\Backend\Module\Translation\Test\AbstractTestCase;
use Jawabkom\Standard\Exception\MethodItNotExistsException;
use Jawabkom\Standard\Exception\NotFoundException;

class DeleteTranslationTest extends AbstractTestCase
{
    private mixed $deleteTransService;
    private mixed $addTransService;
    private mixed $bulkTrans;

    public function setUp(): void
    {
        parent::setUp();
        $this->deleteTransService = $this->app->make(DeleteTranslation::class);
        $this->addTransService    = $this->app->make(AddNewTranslation::class);
        $this->bulkTrans          = $this->app->make(AddBulkTranslations::class);

    }

    //test delete trans by key
    public function testDeleteByKey(){
        $countryCode  = 'ps';
        $languageCode = 'en';
        $groupName    = 'admin';
        $key          = 'projectName';
        $value        = 'translationPackage';

        $newEntity =  $this->addTransService->input('language_code',$languageCode)
                        ->input('country_code',$countryCode)
                        ->input('group_name',$groupName)
                        ->input('key',$key)
                        ->input('value',$value)
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

        $newEntity =  $this->addTransService->input('language_code',$languageCode)
            ->input('country_code',$countryCode)
            ->input('group_name',$groupName)
            ->input('key',$key)
            ->input('value',$value)
            ->process()
            ->output('newEntity');
        $this->assertInstanceOf(ITranslationEntity::class,$newEntity);

        $this->deleteTransService->truncateTranslation()->process();
        $this->assertDatabaseCount('translations',0);

    }
    //test delete trans by group
    public function testDeleteTransByGroup(){
        list($trans, $result) = $this->factoryBulkTranslation();
        $this->assertTrue($result);
        $groupName = $trans[0]['group_name'];
        $deleteStatus = $this->deleteTransService->byTransGroup($groupName)
                                                 ->process()
                                                 ->output('status');
        $this->assertIsArray($deleteStatus);
        $this->assertDatabaseMissing('translations',[
            "groupName"=> $groupName
        ]);
    }
    //test delete trans by language code
    public function testDeleteTransByLocal(){

        list($trans, $result) = $this->factoryBulkTranslation();
        $this->assertTrue($result);
        $local = $trans[0]['language_code'];
         $deleteStatus = $this->deleteTransService->byTransLocal($local)
            ->process()
            ->output('status');
        $this->assertIsArray($deleteStatus);
        $this->assertDatabaseMissing('translations',[
            "languageCode"=> $local
        ]);
    }
    //test try call method not exists
    public function testMethodNotExits(){
        $this->expectError();
        $deletes = $this->app->make(DeleteTranslation::class);
        $deletes->byTransId('test')
             ->process()
             ->output('status');

    }
    /**
     * @return array
     */
    private function factoryBulkTranslation(): array
    {
        $trans = [];
        for ($i = 0; $i < 3; $i++) {
            $trans[] = [
                'language_code' => 'en',
                'key' => "project-{$i}",
                'value' => "translate_model-{$i}",
                'group_name' => 'admin',
                'country_code' => 'ps'
            ];
        }
        $result = $this->bulkTrans->inputs($trans)->process()->output('status');
        return array($trans, $result);
    }
}
