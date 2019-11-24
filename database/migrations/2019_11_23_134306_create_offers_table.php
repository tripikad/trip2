<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->increments('id');
            $table
                ->integer('user_id')
                ->unsigned()
                ->index();
            $table->string('title')->nullable();
            $table
                ->tinyInteger('status')
                ->unsigned()
                ->required(); /* ->index() ? */

            $table->mediumInteger('price')->nullable();

            $table
                ->integer('start_destination_id')
                ->unsigned()
                ->nullable()
                ->index();

            $table
                ->integer('end_destination_id')
                ->unsigned()
                ->nullable()
                ->index();

            $table->json('data')->nullable();

            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->timestamps();

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}

/*
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
            $table->mediumInteger('price')->nullable();

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE contents ADD FULLTEXT INDEX contents_search_full_text (title, body, url)');
    }

    public function down()
    {
        Schema::drop('contents');
    }
  */
