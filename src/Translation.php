<?php

namespace Jawabkom\Backend\Module\Translation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jawabkom\Backend\Module\Translation\Database\Factories\TranslationFactory;

class Translation extends Model
{
    use HasFactory;
    protected $fillable =[
        'key',
        'value',
        'language_code',
        'country_code',
        'group_name',
    ];

    protected static function newFactory(): TranslationFactory
    {
       return TranslationFactory::new();
    }
}