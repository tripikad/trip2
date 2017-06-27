<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration
{
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->string('title')->nullable();
            $table->text('body')->nullable();
            $table->string('type', 20)->index();
            $table->string('url')->nullable();
            $table->tinyInteger('status')->unsigned()->required()->index();
            $table->timestamps();

            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->string('duration')->nullable();
            $table->tinyInteger('price')->nullable();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE contents ADD FULLTEXT INDEX contents_search_full_text (title, body, url)');
    }

    public function down()
    {
        Schema::drop('contents');
    }
}
