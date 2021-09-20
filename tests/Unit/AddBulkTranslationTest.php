<?php

namespace Jawabkom\Backend\Module\Translation\Test\Unit;

use Jawabkom\Backend\Module\Translation\Service\SaveBulkTranslations;
use Jawabkom\Backend\Module\Translation\Test\AbstractTestCase;
use Jawabkom\Standard\Exception\InputLengthException;
use Jawabkom\Standard\Exception\MissingRequiredInputException;

class AddBulkTranslationTest extends AbstractTestCase
{
    protected SaveBulkTranslations $bulkTrans;
    public function setUp(): void
    {
        parent::setUp();
        $this->bulkTrans = $this->app->make(SaveBulkTranslations::class);
    }
    /** @test */
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
       $this->assertIsArray($result);
       $this->assertEquals(3,$result['created']);
    }
    //add bulk with required argument only
    public function testAddBulkTranslationWithRequiredArgumentOnly(){
        $trans =[];
        for ($i=0;$i<3;$i++){
            $trans[] =[
                'language_code'=>'en',
                'key'=>"project-{$i}",
                'value'=>"translate_model-{$i}",
            ];
        }
        $result = $this->bulkTrans->inputs($trans)->process()->output('status');
        $this->assertDatabaseHas('translations',[
            "key"=>"project-1"
        ]);
        $this->assertIsArray($result);
        $this->assertEquals(3,$result['created']);
    }

    public function testLanguageCodeInputLengthLessThanRequiredLength(){
        $trans =[];
        for ($i=0;$i<3;$i++){
            $trans[] =[
                'language_code'=>'e',
                'key'=>"project-{$i}",
                'value'=>"translate_model-{$i}",
            ];
        }
        $this->expectException(InputLengthException::class);
       $this->bulkTrans->inputs($trans)->process()->output('status');
    }
    public function testCountryCodeLengthLessThanRequiredLength(){
        $trans =[];
        for ($i=0;$i<3;$i++){
            $trans[] =[
                'language_code'=>'en',
                'key'=>"project-{$i}",
                'value'=>"translate_model-{$i}",
                'group_name'=>'admin',
                'country_code'=>'s'
            ];
        }
        $this->expectException(InputLengthException::class);
       $this->bulkTrans->inputs($trans)->process()->output('status');
    }

    //add bulk with missing required argument
    public function testAddBulkWithMissingValueRequiredArgument(){
        $trans =[];
        for ($i=0;$i<3;$i++){
            $trans[] =[
                'language_code'=>'en',
                'key'=>"project-{$i}",
                'group_name'=>'admin',
                'country_code'=>'ps'
            ];
        }
        $this->expectException(MissingRequiredInputException::class);
         $this->bulkTrans->inputs($trans)->process()->output('status');

    }
    //add bulk with missing required argument
    public function testAddBulkWithMissingKeyRequiredArgument(){
        $trans =[];
        for ($i=0;$i<3;$i++){
            $trans[] =[
                'language_code'=>'en',
                 'group_name'=>'admin',
                'country_code'=>'ps',
                'value'=>"translate_model-{$i}",
            ];
        }
        $this->expectException(MissingRequiredInputException::class);
         $this->bulkTrans->inputs($trans)->process()->output('status');

    }
    //test sensitive key value at  add bulk translation
    public function testIgnoreSensitiveKeyAtAddBulkTranslation(){
        $trans =[];
        for ($i=0;$i<3;$i++){
            $trans[] =[
                'language_code'=>'en',
                'key'=>"PROJECT-{$i}",
                'value'=>"translate_model-{$i}",
            ];
        }
        $result = $this->bulkTrans->inputs($trans)->process()->output('status');
        $this->assertDatabaseHas('translations',[
            "key"=>"project-1"
        ]);
        $this->assertIsArray($result);
        $this->assertEquals(3,$result['created']);
    }

    public function testUpperCaseCountryCodeAtAddBulkTranslation(){
        $trans =[];
        for ($i=0;$i<3;$i++){
            $trans[] =[
                'language_code'=>'en',
                'key'=>"PROJECT-{$i}",
                'value'=>"translate_model-{$i}",
                'country_code'=>'ps'
            ];
        }
        $result = $this->bulkTrans->inputs($trans)->process()->output('status');
        $this->assertDatabaseHas('translations',[
            "country_code"=>"PS"
        ]);
        $this->assertIsArray($result);
        $this->assertEquals(3,$result['created']);
    }

}
