<?php

namespace Jawabkom\Backend\Module\Translation;

use Illuminate\Database\Eloquent\Model;
use Jawabkom\Backend\Module\Translation\Database\Factories\TranslationFactory;
use Jawabkom\Standard\Contract\IEntity;

abstract class AbstractTranslation extends Model
{
    protected $fillable =[
        'key',
        'value',
        'language_code',
        'country_code',
        'group_name',
    ];
}