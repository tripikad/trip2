<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poll_results', function (Blueprint $table) {
            $table->increments('poll_result_id');
			$table->unsignedInteger('poll_id');
			$table->foreign('poll_id')->references('id')->on('poll');
			$table->unsignedInteger('field_id');
			$table->foreign('field_id')->references('field_id')->on('poll_fields');
			$table->unsignedInteger('user_id');
			$table->foreign('user_id')->references('id')->on('users');
			$table->json('result');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('poll_results');
    }
}
