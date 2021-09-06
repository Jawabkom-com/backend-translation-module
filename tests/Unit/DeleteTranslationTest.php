<?php

namespace Jawabkom\Backend\Module\Translation\Test\Unit;

use Jawabkom\Backend\Module\Translation\Service\DeleteTranslation;
use Jawabkom\Backend\Module\Translation\Test\AbstractTestCase;

class DeleteTranslationTest extends AbstractTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->trans = $this->app->make(DeleteTranslation::class);
    }

    //test delete trans by key
    //test delete key is not exits
    //test delete trans all
    //test delete trans by group
    //test delete trans by language code
}