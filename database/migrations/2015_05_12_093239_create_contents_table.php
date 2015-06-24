<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration
{
    public function up()
    {
        Schema::create('contents', function(Blueprint $table) {
            $table->increments('id');   
            $table->integer('user_id')->index();    
            $table->string('title');
            $table->text('body');
            $table->string('type');
            $table->string('image');
            $table->string('url');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('contents');
    }
}
