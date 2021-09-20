<?php

namespace Jawabkom\Backend\Module\Translation\Test\Unit;

use Jawabkom\Backend\Module\Translation\Contract\ITranslationEntity;
use Jawabkom\Backend\Module\Translation\Service\SaveTranslation;
use Jawabkom\Backend\Module\Translation\Test\AbstractTestCase;

class UpdateTranslationsTest extends AbstractTestCase
{
    private mixed $updateTrans;

    public function setUp(): void
    {
        parent::setUp();
        $this->updateTrans = $this->app->make(SaveTranslation::class);
    }

    //test updateTranslationByKey
    public function testUpdateTranslationByKey(){
        $languageCode = 'en';
        $key          = 'projectName';
        $value        = 'translationPackage';

        $newUpdate= $this->updateTrans->input('language_code',$languageCode)
                                      ->input('key',$key)
                                      ->input('value',$value)
                                      ->process()
                                      ->output('entity');
         $this->assertInstanceOf(ITranslationEntity::class,$newUpdate);
        $this->assertDatabaseHas('translations',[
            'value'=>$value,
        ]);

        $newValue = 'Jawabkom Package';
        $filter =[
            'key' => $key
        ];

        $result = $this->updateTrans->input('filters',$filter)
                                           ->input('value',$newValue)
                                           ->process()
                                           ->outputs('entity');

        $this->assertFalse($result['is_new_entity']);
        $this->assertDatabaseHas('translations',[
            'value'=>$result['entity']->getTranslationValue(),
        ]);
    }
}