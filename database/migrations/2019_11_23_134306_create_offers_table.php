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
            $table->string('style', 20)->index();

            $table
                ->integer('user_id')
                ->unsigned()
                ->index();

            $table
                ->integer('start_destination_id')
                ->unsigned()
                ->index();

            $table
                ->integer('end_destination_id')
                ->unsigned()
                ->index();

            $table->string('title')->nullable();
            $table
                ->tinyInteger('status')
                ->unsigned()
                ->required(); /* ->index() ? */

            $table->mediumInteger('price')->nullable();

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
