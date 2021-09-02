<?php

namespace Jawabkom\Backend\Module\Translation\Provider;

use Illuminate\Support\ServiceProvider;
use Jawabkom\Backend\Module\Translation\Database\Migrations\CreateTranslationTable;
use Jawabkom\Backend\Module\Translation\Repositories\TranslationRepository;
use Jawabkom\Backend\Module\Translation\Translation;

class TranslationServiceProvider extends ServiceProvider
{
    public function boot(){
        $this->registerResources();
    }

    public function register()
    {
        $toBind = [
            TranslationRepository::class => Translation::class,
        ];

        foreach ($toBind as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    private function registerResources()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}