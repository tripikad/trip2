<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('searchables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->string('content_type', 10)->nullable()->index();
            $table->integer('content_id')->nullable()->unsigned()->index();
            $table->integer('comment_id')->nullable()->unsigned()->index();
            $table->integer('destination_id')->nullable()->unsigned()->index();
            $table->string('title', 255)->nullable();
            $table->text('body')->nullable();
            $table->timestamps();

            $table->foreign('content_id')->references('id')->on('contents')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('comment_id')->references('id')->on('comments')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('destination_id')->references('id')->on('destinations')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE `searchables` ADD FULLTEXT INDEX searchable_full_text (`title`, `body`)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('searchables');
    }
}
