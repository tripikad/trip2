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
            $table->integer('newsletter_type_id')->unsigned()->index();
            $table->longText('composed_content');
            $table->timestamp('started_at');
            $table->timestamp('ended_at');

            $table->foreign('newsletter_type_id')->references('id')->on('newsletter_types')
                ->onUpdate('cascade')->onDelete('cascade');
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
