<?php

namespace Jawabkom\Backend\Module\Translation\Test\Unit;

use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Backend\Module\Translation\Service\AddBulkTranslations;
use Jawabkom\Backend\Module\Translation\Service\GetTranslations;
use Jawabkom\Backend\Module\Translation\Test\AbstractTestCase;

class GetTranslationsTest extends AbstractTestCase
{
    private GetTranslations $trans;
    private $addBulkTrans;

    public function setUp(): void
    {
        parent::setUp();
        $this->trans = $this->app->make(GetTranslations::class);
        $this->addBulkTrans = $this->app->make(AddBulkTranslations::class);
    }

    //test list sll Translation
    public function testListTranslation(){
       $this->factoryBulkTranslation();
       $result = $this->trans->listTrnasltion()->output('list');
       $this->assertIsArray($result);
       $this->assertNotEmpty($result);
       $this->assertInstanceOf(ITranslationRepository::class,$result[0]);
    }

    //test list by group name
    public function testListTransByGroupName(){
        $dummyData = $this->factoryBulkTranslation();
        $result    = $this->trans->byGroupName($dummyData['data'][0]['group_name'])->process()->output('list');
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertInstanceOf(ITranslationRepository::class,$result[0]);
     }
    //test list by key
    public function testGetTransByKey(){
        $dummyData = $this->factoryBulkTranslation();
        $result    = $this->trans->byKey($dummyData['data'][0]['key'])->process()->output('list');
        $this->assertNotEmpty($result);
        $this->assertInstanceOf(ITranslationRepository::class,$result);
        $this->assertEquals($dummyData['data'][0]['key'],$result->key);
    }

    //test list by key
    public function testGetTransByValue(){
        $dummyData = $this->factoryBulkTranslation();
        $result    = $this->trans->byValue($dummyData['data'][0]['value'])->process()->output('list');
        $this->assertNotEmpty($result);
        $this->assertInstanceOf(ITranslationRepository::class,$result);
        $this->assertEquals($dummyData['data'][0]['value'],$result->value);
    }
    //test list local
    public function testListTransByLocal(){
        $dummyData = $this->factoryBulkTranslation();
        $result    = $this->trans->byLocal($dummyData['data'][0]['language_code'])->process()->output('list');
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertInstanceOf(ITranslationRepository::class,$result[0]);
    }
    //test filter and Paginate
    public function testFilteringWithAllOptionalAndPaginate(){
        $dummyData = $this->factoryBulkTranslation(30);
        $result    = $this->trans->byLocal($dummyData['data'][0]['language_code'])->process()->output('list');
        $this->assertCount(30,$result);
        $local       ='en';
        $key         = 'project-29';
        $groupName   = 'admin';
        $value       = 'translate_model-29';
        $countryCode ='ps';
        $paginate    = true;
        $perPage     =3;
        $this->assertDatabaseHas('translations',[
            'key'=>'project-29'
        ]);
         $result = $this->trans->filterBy($key,$value,$local,$groupName,$countryCode,$paginate,$perPage)
                              ->process()
                              ->output('list');

         $this->assertEquals($perPage,$result->perPage());
         $this->assertEquals(1,$result->currentPage());
         $this->assertNotEmpty($result->all());
         $this->assertInstanceOf(ITranslationRepository::class,$result->all()[0]);
    }
    //test filter without Paginate
    public function testFilteringWithAllOptionalWithOutPaginate(){
        $dummyData = $this->factoryBulkTranslation(30);
        $result    = $this->trans->byLocal($dummyData['data'][0]['language_code'])->process()->output('list');
        $this->assertCount(30,$result);
        $local       ='en';
        $key         = 'project-20';
        $groupName   = 'admin';
        $value       = 'translate_model-20';
        $countryCode ='ps';
        $paginate    = false;
        $this->assertDatabaseHas('translations',[
            'key'=>'project-29'
        ]);
         $result = $this->trans->filterBy($key,$value,$local,$groupName,$countryCode,$paginate)
                              ->process()
                              ->output('list');

         $this->assertIsArray($result);
         $this->assertNotEmpty($result);
          $this->assertInstanceOf(ITranslationRepository::class,$result[0]);
    }
    //test filter by key
    public function testFilterByKey(){
        $dummyData = $this->factoryBulkTranslation(30);
        $result    = $this->trans->byKey($dummyData['data'][0]['key'])->process()->output('list');

        $key         = 'project-10';
        $paginate    = false;
        $this->assertDatabaseHas('translations',[
            'key'=>$key
        ]);
         $result = $this->trans->filterBy(key:$key,paginate: $paginate)
                              ->process()
                              ->output('list');

         $this->assertIsArray($result);
         $this->assertNotEmpty($result);
          $this->assertInstanceOf(ITranslationRepository::class,$result[0]);
    }
    //test filter by Value
    public function testFilterByValue(){
        $dummyData = $this->factoryBulkTranslation(30);
        $result    = $this->trans->byValue($dummyData['data'][0]['value'])->process()->output('list');
        $value       = 'translate_model-15';
        $paginate    = false;
        $this->assertDatabaseHas('translations',[
            'value'=>$value
        ]);
         $result = $this->trans->filterBy(value:$value,paginate: $paginate)
                              ->process()
                              ->output('list');

         $this->assertIsArray($result);
         $this->assertCount(1,$result);
         $this->assertNotEmpty($result);
         $this->assertInstanceOf(ITranslationRepository::class,$result[0]);
    }

    //test filter by language code
    public function testFilterByLocal(){
        $dummyData = $this->factoryBulkTranslation(30);
        $result    = $this->trans->byLocal($dummyData['data'][0]['language_code'])->process()->output('list');
        $this->assertCount(30,$result);
        $local       = 'en';
        $paginate    = false;

         $result = $this->trans->filterBy(local:$local,paginate: $paginate)
                              ->process()
                              ->output('list');

         $this->assertIsArray($result);
         $this->assertNotEmpty($result);
         $this->assertInstanceOf(ITranslationRepository::class,$result[0]);
    }
    //test filter by country code
    public function testFilterByCountryCode(){
        $this->factoryBulkTranslation(30);
        $countryCode = 'ps';
        $paginate    = false;

         $result = $this->trans->filterBy(countryCode:$countryCode,paginate: $paginate)
                              ->process()
                              ->output('list');

         $this->assertIsArray($result);
         $this->assertNotEmpty($result);
         $this->assertInstanceOf(ITranslationRepository::class,$result[0]);
    }
    //test filter by group Name
    public function testFilterByGroupName(){
        $dummyData = $this->factoryBulkTranslation(30);
        $result    = $this->trans->byGroupName($dummyData['data'][0]['group_name'])->process()->output('list');
        $this->assertCount(30,$result);
        $groupName = 'admin';
        $paginate    = false;

         $result = $this->trans->filterBy(groupName:$groupName,paginate: $paginate)
                              ->process()
                              ->output('list');

         $this->assertIsArray($result);
         $this->assertNotEmpty($result);
         $this->assertInstanceOf(ITranslationRepository::class,$result[0]);
    }


    private function factoryBulkTranslation(int $intx =3): array
    {
        $trans = [];
        for ($i = 0; $i < $intx; $i++) {
            $trans[] = [
                'language_code' => 'en',
                'key' => "project-{$i}",
                'value' => "translate_model-{$i}",
                'group_name' => 'admin',
                'country_code' => 'ps'
            ];
        }
        $result = $this->addBulkTrans->inputs($trans)->process()->output('status');
        return array('data'=>$trans, 'status'=>$result);
    }

}