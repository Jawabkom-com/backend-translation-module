<?php

namespace Jawabkom\Backend\Module\Translation\Test\Classes\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslationTable extends Migration
{
    public function up(){
        Schema::create('translations',function (Blueprint $table){
            $table->id();
            $table->string('key')->index();
            $table->string('value')->index();
            $table->string('language_code')->index();
            $table->string('country_code')->nullable();
            $table->string('group_name')->nullable();

            $table->timestamps();
        });
    }
    public function down(){
        Schema::dropIfExists('translations');
    }

}