<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsletterSentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletter_sents', function (Blueprint $table) {
            $table->increments('id');
            $table
                ->integer('newsletter_type_id')
                ->unsigned()
                ->index();
            $table->longText('composed_content');
            $table
                ->integer('destination_id')
                ->nullable()
                ->unsigned()
                ->index();
            $table
                ->boolean('price_error')
                ->default(0)
                ->index();
            $table
                ->integer('content_id')
                ->nullable()
                ->unsigned()
                ->index();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();

            $table
                ->foreign('newsletter_type_id')
                ->references('id')
                ->on('newsletter_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table
                ->foreign('destination_id')
                ->references('id')
                ->on('destinations')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table
                ->foreign('content_id')
                ->references('id')
                ->on('contents')
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
        Schema::dropIfExists('newsletter_sents');
    }
}
