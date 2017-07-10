<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration
{
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->string('title');
            $table->text('body')->nullable();
            $table->string('type')->index();
            $table->string('url')->nullable();
            $table->integer('status')->required()->index();
            $table->timestamps();

            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->string('duration')->nullable();
            $table->integer('price')->nullable();
        });
    }

    public function down()
    {
        Schema::drop('contents');
    }
}
