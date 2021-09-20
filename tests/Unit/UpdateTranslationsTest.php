<?php

namespace Jawabkom\Backend\Module\Translation\Test\Unit;

use Jawabkom\Backend\Module\Translation\Contract\ITranslationEntity;
use Jawabkom\Backend\Module\Translation\Service\SaveTranslation;
use Jawabkom\Backend\Module\Translation\Service\UpdateTranslations;
use Jawabkom\Backend\Module\Translation\Test\AbstractTestCase;

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

        $addNewTrans = $this->app->make(SaveTranslation::class);
        $result = $addNewTrans->input('language_code',$languageCode)
                              ->input('key',$key)
                              ->input('value',$value)
                              ->process()
                              ->output('newEntity');
        $this->assertInstanceOf(ITranslationEntity::class,$result);
        $this->assertDatabaseHas('translations',[
            'value'=>$value,
        ]);

        $newValue = 'Jawabkom Package';
        $filter =[
            'key' => $key
        ];

        $status = $this->updateTrans->input('filters',$filter)
                                           ->input('newValue',['value'=>$newValue])
                                           ->process()
                                           ->output('status');
        $this->assertTrue($status);
        $this->assertDatabaseHas('translations',[
            'value'=>$newValue,
        ]);
    }
}