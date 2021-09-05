<?php

namespace Jawabkom\Backend\Module\Translation\Test\Classes\Provider;

use Illuminate\Support\ServiceProvider;
use Jawabkom\Backend\Module\Translation\Contract\ITranslationEntity;
use Jawabkom\Backend\Module\Translation\Contract\ITranslationRepository;
use Jawabkom\Backend\Module\Translation\Test\Classes\TranslationEntity;
use Jawabkom\Backend\Module\Translation\Test\Classes\TranslationRepository;

class TranslationServiceProvider extends ServiceProvider
{
    public function boot(){
        $this->registerResources();
        $this->publish();
    }

    public function register()
    {
        $toBind = [
            ITranslationRepository::class => TranslationRepository::class,
            ITranslationEntity::class     => TranslationEntity::class
        ];

        foreach ($toBind as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    private function registerResources()
    {
        $this->loadMigrations();
        $this->loadConfig();
     //   $this->loadRoutes();
    }

    private function loadMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    public function loadConfig(){
        $this->mergeConfigFrom(__DIR__ . '/../../Config/config.php','jawabAdmin');
    }

    private function loadRoutes(): void
    {
        \Illuminate\Support\Facades\Route::group($this->routesConfigurations(),function (){
            $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        });
    }

    private function routesConfigurations(){
        return [
            'prefix' => config('translation.route.prefix'),
            'middleware' => config('jawabAdmin.translation.route.middleware'),
        ];
    }

    private function publish()
    {
        if ($this->app->runningInConsole()){
            $this->publishes([
                __DIR__ . '/../../Config/config.php' =>config('jawabAdmin')
            ],'config');
        }
    }
}