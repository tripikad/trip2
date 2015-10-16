<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentTopicTable extends Migration
{
    public function up()
    {
        Schema::create('content_topic', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('content_id')->index();
            $table->integer('topic_id')->index();
        });
    }

    public function down()
    {
        Schema::drop('content_topic');
    }
}
