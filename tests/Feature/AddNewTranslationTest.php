<?php

namespace Jawabkom\Backend\Module\Translation\Test\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Jawabkom\Backend\Module\Translation\Service\AddNewTranslation;
use Jawabkom\Backend\Module\Translation\Test\AbstractTestCase;

class AddNewTranslationTest extends AbstractTestCase
{
    use RefreshDatabase;
    public function testCreateTranslation(){
        $t = $this->app->make(AddNewTranslation::class);
        dd($t);
        $t->save();
    //    $this->assertInstanceOf(,$t);
    }
    public function testCreateTranslationKey(){

    }

    public function testTrimKey(){

    }

}