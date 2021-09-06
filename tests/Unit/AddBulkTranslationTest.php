<?php

namespace Jawabkom\Backend\Module\Translation\Test\Unit;

use Jawabkom\Backend\Module\Translation\Service\AddBulkTranslations;
use Jawabkom\Backend\Module\Translation\Test\AbstractTestCase;

class AddBulkTranslationTest extends AbstractTestCase
{
    protected AddBulkTranslations $bulkTrans;
    public function setUp(): void
    {
        parent::setUp();
        $this->bulkTrans = $this->app->make(AddBulkTranslations::class);
    }

    //add bulk translation
    public function testAddBulkTranslation(){
        $trans =[];
        for ($i=0;$i<3;$i++){
            $trans[] =[
                'language_code'=>'en',
                'key'=>"project-{$i}",
                'value'=>"translate_model-{$i}",
                'group_name'=>'admin',
                'country_code'=>'ps'
            ];
        }
      $result = $this->bulkTrans->inputs($trans)->process()->output('status');
      $this->assertDatabaseHas('translations',[
            "key"=>"project-1"
      ]);
      $this->assertTrue($result);
    }
    //add bulk with missing required argument
    //add bulk with required argument
}