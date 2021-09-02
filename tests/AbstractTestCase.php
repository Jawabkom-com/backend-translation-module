<?php

namespace Jawabkom\Backend\Module\Translation\Test;

use Jawabkom\Backend\Module\Translation\Database\Migrations\CreateTranslationTable;
use Jawabkom\Backend\Module\Translation\Provider\TranslationServiceProvider;
use Orchestra\Testbench\TestCase as TestCaseAlisa;

class AbstractTestCase extends TestCaseAlisa
{

    public function setUp(): void
    {
        parent::setUp();
   //   $this->withFactories(__DIR__.'/../src/Database/Factories');
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return string[]
     */
    protected function getPackageProviders($app): array
    {
        return [
            TranslationServiceProvider::class,
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testDB');
        $app['config']->set('database.connections.testDB', [
            'driver' => 'sqlite',
            'database' => ':memory:'
        ]);
        $classes =[
            "CreateTranslationTable",
        ];
        foreach($classes as $class){
          $class ="\\Jawabkom\\Backend\\Module\\Translation\\Database\\Migrations\\{$class}";
            (new $class)->up();
        }

    }

}