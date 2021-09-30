<?php

namespace Jawabkom\Backend\Module\Translation\Test\Unit;

use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Backend\Module\Translation\Service\GetTranslationsByKey;
use Jawabkom\Backend\Module\Translation\Test\AbstractTestCase;
use Jawabkom\Standard\Exception\InputLengthException;
use Jawabkom\Standard\Exception\MissingRequiredInputException;

class GetTranslationsByKeyTest extends AbstractTestCase
{
    //test list by key
    public function testGetTransByKey(){
        $dummyData = $this->factoryBulkTranslation();
            $key = $dummyData[0][2]['key'];
        $translateByKeyService = $this->app->make(GetTranslationsByKey::class);
        $result                 = $translateByKeyService->input('key',$key)
                                                        ->process()
                                                         ->output('entity');
        $this->assertNotEmpty($result);
        $this->assertInstanceOf(ITranslationRepository::class,$result);
        $this->assertEquals($dummyData[0][2]['key'],$result->getTranslationKey());
    }

    public function testMissingKey(){
        $dummyData = $this->factoryBulkTranslation();
        $this->expectExceptionMessage('missing required fields [key*]');
        $translateByKeyService = $this->app->make(GetTranslationsByKey::class);
        $result                 = $translateByKeyService->process()
                                                         ->output('entity');
        $this->assertNotEmpty($result);
        $this->assertInstanceOf(ITranslationRepository::class,$result);
        $this->assertEquals($dummyData[0][2]['key'],$result->getTranslationKey());
    }

    public function testCountryCodeMoreRequiredLengthTransByKey(){
        $dummyData = $this->factoryBulkTranslation();
        $key = $dummyData[0][2]['key'];
        $this->expectException(InputLengthException::class);
        $translateByKeyService = $this->app->make(GetTranslationsByKey::class);
         $translateByKeyService->input('key',$key)->input('country_code','EEEe')
                                                  ->process()
                                                  ->output('entity');
    }
    public function testLocalMoreRequiredLengthTransByKey(){
        $dummyData = $this->factoryBulkTranslation();
        $key = $dummyData[0][2]['key'];
        $this->expectException(InputLengthException::class);
        $translateByKeyService = $this->app->make(GetTranslationsByKey::class);
         $translateByKeyService->input('key',$key)->input('language_code','EEEe')
                                                  ->process()
                                                  ->output('entity');
    }


}