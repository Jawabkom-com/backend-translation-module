<?php

namespace Jawabkom\Backend\Module\Translation\Test\Unit;

use Jawabkom\Backend\Module\Translation\Service\SaveBulkTranslations;
use Jawabkom\Backend\Module\Translation\Service\SaveTranslation;
use Jawabkom\Backend\Module\Translation\Service\DeleteTranslation;
use Jawabkom\Backend\Module\Translation\Test\AbstractTestCase;

class DeleteTranslationTest extends AbstractTestCase
{
    private mixed $deleteTransService;
    private mixed $addTransService;
    private mixed $bulkTrans;

    public function setUp(): void
    {
        parent::setUp();
        $this->deleteTransService = $this->app->make(DeleteTranslation::class);
        $this->addTransService = $this->app->make(SaveTranslation::class);
        $this->bulkTrans = $this->app->make(SaveBulkTranslations::class);

    }

    //test delete trans by key
    public function testDeleteByKey()
    {
        $countryCode = 'ps';
        $languageCode = 'en';
        $groupName = 'admin';
        $key = 'projectName';
        $value = 'translationPackage';

        $newEntity = $this->addTransService->input('language_code', $languageCode)
            ->input('country_code', $countryCode)
            ->input('group_name', $groupName)
            ->input('key', $key)
            ->input('value', $value)
            ->process()
            ->output('entity');
        $filter = [
            'key' => $newEntity->getTranslationKey()
        ];
        $deleteStatus = $this->deleteTransService->input('filters', $filter)
            ->process()
            ->output('status');
        $this->assertDatabaseMissing('translations', [
            'key' => $newEntity->getTranslationKey()
        ]);
        $this->assertIsArray($deleteStatus);
        $this->assertNotEmpty($deleteStatus);
    }

    //test delete trans by group
    public function testDeleteTransByGroup()
    {
        list($trans, $result) = $this->factoryBulkTranslation();
        $this->assertEquals(3, $result['created']);
        $filter = [
            'group_name' => $trans[0]['group_name']
        ];
        $deleteStatus = $this->deleteTransService->input('filters', $filter)
            ->process()
            ->output('status');
        $this->assertIsArray($deleteStatus);
        $this->assertDatabaseMissing('translations', [
            "group_name" => $trans[0]['group_name']
        ]);
    }

    public function testDeleteNotExists()
    {
        $filter = [
            'group_name' => 'ksdajfksdjf'
        ];
        $deleteStatus = $this->deleteTransService->input('filters', $filter)
            ->process()
            ->output('status');
        $this->assertIsArray($deleteStatus);
        $this->assertEmpty($deleteStatus['deleted']);
        $this->assertEmpty($deleteStatus['failed']);
        $this->assertDatabaseMissing('translations', [
            "group_name" => 'ksdajfksdjf'
        ]);
    }

    //test delete trans by language code
    public function testDeleteTransByLocal()
    {

        list($trans, $result) = $this->factoryBulkTranslation();
        $local = $trans[0]['language_code'];
        $this->assertEquals(3,$result['created']);
        $filter =[
            'language_code' => $local
        ];

         $deleteStatus = $this->deleteTransService->input('filters',$filter)
                                                  ->process()
                                                  ->output('status');
        $this->assertIsArray($deleteStatus);
        $this->assertDatabaseMissing('translations',[
            "language_code"=> $local
        ]);
    }

    //test try call method not exists
    public function testMethodNotExits()
    {
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
