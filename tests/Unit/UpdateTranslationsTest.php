<?php

namespace Jawabkom\Backend\Module\Translation\Test\Unit;

use Jawabkom\Backend\Module\Translation\Contract\ITranslationEntity;
use Jawabkom\Backend\Module\Translation\Service\AddNewTranslation;
use Jawabkom\Backend\Module\Translation\Service\UpdateTranslations;
use Jawabkom\Backend\Module\Translation\Test\AbstractTestCase;
use Jawabkom\Standard\Exception\NotFoundException;

class UpdateTranslationsTest extends AbstractTestCase
{
    private mixed $updateTrans;

    public function setUp(): void
    {
        parent::setUp();
        $this->updateTrans = $this->app->make(UpdateTranslations::class);
    }

    //test updateTranslationByKey
    public function testUpdateTranslationByKey(){
        $languageCode = 'en';
        $key          = 'projectName';
        $value        = 'translationPackage';

        $addNewTrans = $this->app->make(AddNewTranslation::class);
        $result = $addNewTrans->input('languageCode',$languageCode)
            ->input('translationKey',$key)
            ->input('translationValue',$value)
            ->process()->output('newEntity');
        $this->assertInstanceOf(ITranslationEntity::class,$result);
        $this->assertDatabaseHas('translations',[
            'value'=>$value,
        ]);

        $newValue = 'Jawabkom Package';
        $status   = $this->updateTrans->byKey($key,[
                        'value'=> $newValue,
                        ])->process()->output('status');
        $this->assertTrue($status);
        $this->assertDatabaseHas('translations',[
            'value'=>$newValue,
        ]);
    }
    //test update not exists trans key
    public function testUpdateTranslationByKeyNotExists(){
        $this->expectException(NotFoundException::class);
       $this->updateTrans->byKey('testToTest',[
            'value'=> 'update with not exits key',
        ])->process()->output('status');
     }
}