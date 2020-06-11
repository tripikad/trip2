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
            $table->unsignedInteger('poll_option_id');
            $table->unsignedInteger('poll_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('ip_address')->nullable();

            $table
                ->foreign('poll_option_id')
                ->references('id')
                ->on('poll_options')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table
                ->foreign('poll_id', 'fk_poll_results_poll_id')
                ->references('id')
                ->on('polls')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table
                ->foreign('user_id', 'fk_poll_results_user_id')
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
        Schema::dropIfExists('poll_results');
    }
}
