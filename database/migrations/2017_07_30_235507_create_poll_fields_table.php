<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poll_fields', function (Blueprint $table) {
            $table->increments('field_id');
            $table->unsignedInteger('poll_id');
            $table->foreign('poll_id')->references('id')->on('poll')->onDelete('cascade');
            $table->string('type');
            $table->json('options');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('poll_fields');
    }
}
