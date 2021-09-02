<?php

namespace Jawabkom\Backend\Module\Translation\Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Jawabkom\Backend\Module\Translation\Translation;

class TranslationFactory extends  Factory
{
    protected $model = Translation::class;

    public function definition()
    {
        return [
            'country_code'=>'test',
            'language_code'=>'test',
            'key'=>'test',
            'value'=>'test',
            'group_name'=>'test',
        ];
    }

}