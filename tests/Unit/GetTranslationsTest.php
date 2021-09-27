<?php

namespace Jawabkom\Backend\Module\Translation\Test\Unit;

use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Backend\Module\Translation\Exception\FilterNameDoesNotExistsException;
use Jawabkom\Backend\Module\Translation\Service\SaveBulkTranslations;
use Jawabkom\Backend\Module\Translation\Service\GetTranslationsByFilter;
use Jawabkom\Backend\Module\Translation\Test\AbstractTestCase;

class GetTranslationsTest extends AbstractTestCase
{
    private GetTranslationsByFilter $trans;
    private $addBulkTrans;

    public function setUp(): void
    {
        parent::setUp();
        $this->trans = $this->app->make(GetTranslationsByFilter::class);
        $this->addBulkTrans = $this->app->make(SaveBulkTranslations::class);
    }

    //test list sll Translation
  public function testListTranslation(){
       $this->factoryBulkTranslation();
       $result = $this->trans->process()->output('translations');
       $this->assertIsArray($result);
       $this->assertNotEmpty($result);
       $this->assertInstanceOf(ITranslationRepository::class,$result[0]);
    }


    //test list by group name
    public function testListTransByGroupName(){
        $dummyData = $this->factoryBulkTranslation();
        $filter =[
          'group_name'=>$dummyData['data'][0]['group_name']
        ];

        $result    = $this->trans->input('filters',$filter)->process()->output('translations');

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertInstanceOf(ITranslationRepository::class,$result[0]);
     }
    //test list by key
    public function testGetTransByKey(){
        $dummyData = $this->factoryBulkTranslation();
        $filter = [
            'key' => $dummyData['data'][0]['key']
        ];

        $result    = $this->trans->input('filters',$filter)->process()->output('translations');

        $this->assertNotEmpty($result);
        $this->assertInstanceOf(ITranslationRepository::class,$result[0]);
        $this->assertEquals($dummyData['data'][0]['key'],$result[0]->key);
    }

    //test list by key
    public function testGetTransByValue(){
        $dummyData = $this->factoryBulkTranslation();
        $filter =[
            'value' => $dummyData['data'][0]['value']
        ];
        $result    = $this->trans->input('filters',$filter)->process()->output('translations');
        $this->assertNotEmpty($result);
        $this->assertInstanceOf(ITranslationRepository::class,$result[0]);
        $this->assertEquals($dummyData['data'][0]['value'],$result[0]->value);
    }
    //test list local
    public function testListTransByLocal(){
        $dummyData = $this->factoryBulkTranslation();
        $filter =[
            'language_code' => $dummyData['data'][0]['language_code']
        ];

        $result    = $this->trans->input('filters',$filter)->process()->output('translations');
         $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertInstanceOf(ITranslationRepository::class,$result[0]);
    }
    //test filter with more one filter
    public function testFilterWithMoreOneFilter(){
        $dummyData = $this->factoryBulkTranslation();
        $filter =[
            'language_code' => $dummyData['data'][0]['language_code'],
            'key'          => $dummyData['data'][0]['key'],
            'value'        => $dummyData['data'][0]['value']
        ];

        $result    = $this->trans->input('filters',$filter)->process()->output('translations');
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertInstanceOf(ITranslationRepository::class,$result[0]);
    }
    //test filter with more one filter
    public function testFilterWithOrderByCreatedByDec(){
        $dummyData = $this->factoryBulkTranslation(40);
        $filter =[
            'language_code' => $dummyData['data'][0]['language_code'],
            'key'          => $dummyData['data'][0]['key'],
            'value'        => $dummyData['data'][0]['value'],
         ];
        $orderBy =[
          'created_at' => 'desc'
        ];
        $result    = $this->trans->input('filters',$filter)
                                 ->input('orderBy',$orderBy)
                                 ->process()
                                 ->output('translations');
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertInstanceOf(ITranslationRepository::class,$result[0]);
    }
    //test filter with more one filter
    public function testFilterNotExitsColumn(){
         $filter =[
            'languageCodexxxxx' => 'dsajdokljaslkdas',
          ];
         $this->expectException(FilterNameDoesNotExistsException::class);
         $result    = $this->trans->input('filters',$filter)
                                  ->process()
                                 ->output('translations');
        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        $this->assertInstanceOf(ITranslationRepository::class,$result[0]);
    }

     //test filter and Paginate
    public function testFilteringWithAllOptionalAndPaginate(){
        $dummyData = $this->factoryBulkTranslation(30);
        $filter =[
            'language_code' => $dummyData['data'][0]['language_code']
        ];
        $perPage     = 5;
        $currentPage = 1;
        $result    = $this->trans->input('filter',$filter)->input('page',$currentPage)->input('perPage',$perPage)->process()->output('translations');
        $pager     = $result[0]->paginate(5);
        $this->assertCount(5,$pager);
        $this->assertDatabaseHas('translations',[
            'key'=>'project-29'
        ]);
        $this->assertEquals($perPage,$pager->perPage());
        $this->assertEquals($currentPage,$pager->currentPage());
        $this->assertNotEmpty($pager->all());
        $this->assertInstanceOf(ITranslationRepository::class,$pager->all()[0]);
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