<?php

namespace Jawabkom\Backend\Module\Translation\Test\Classes;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractTranslation extends Model
{
    protected $table ='translations';
    protected $fillable =[
        'key',
        'value',
        'language_code',
        'country_code',
        'group_name',
    ];
}