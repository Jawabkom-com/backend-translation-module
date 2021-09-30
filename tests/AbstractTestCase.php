<?php

namespace Jawabkom\Backend\Module\Translation\Test;

use Jawabkom\Backend\Module\Translation\Service\SaveBulkTranslations;
use Jawabkom\Backend\Module\Translation\Test\Classes\Provider\TranslationServiceProvider;
use Orchestra\Testbench\TestCase as TestCaseAlisa;

class AbstractTestCase extends TestCaseAlisa
{

    public function setUp(): void
    {
        parent::setUp();
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
          $class ="\\Jawabkom\\Backend\\Module\\Translation\\Test\\Classes\\Database\\Migrations\\{$class}";
            (new $class)->up();
        }

    }

    protected function factoryBulkTranslation(int $intx =3): array
    {
        $trans = [];
        for ($i = 0; $i < $intx; $i++) {
            $trans[] = [
                'language_code' => 'en',
                'key' => "project-{$i}",
                'value' => "translate_model-{$i}",
                'group_name' => 'admin',
                'country_code' => 'ps'
            ];
        }
        $addBulkTrans = $this->app->make(SaveBulkTranslations::class);
        $result       = $addBulkTrans->inputs($trans)->process()->output('status');
        return array($trans,$result);
    }


}