<?php

namespace Jawabkom\Backend\Module\Translation\Test;

use PHPUnit\Framework\TestCase;

class AbstractTestCase extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        //$this->setOutputCallback(function() {});
    }
}