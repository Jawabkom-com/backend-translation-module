<?php

namespace Jawabkom\Backend\Module\Translation\Test\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jawabkom\Backend\Module\Translation\Repositories\TranslationRepository;
use Jawabkom\Backend\Module\Translation\Test\AbstractTestCase;
use Jawabkom\Backend\Module\Translation\Translation;

class AddNewTranslationTest extends AbstractTestCase
{
    use RefreshDatabase;
    public function testCreateTranslation(){
        $t = $this->app->make(TranslationRepository::class);
        $t->key='1';
        $t->value='22';
        $t->language_code='333';
        $t->country_code='444';
        $t->save();
        $this->assertInstanceOf(i,$t);
    }
    public function testCreateTranslationKey(){

    }

    public function testTrimKey(){

    }

}