<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsletterLetterContents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletter_letter_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('newsletter_type_id')->unsigned()->index();
            $table->integer('newsletter_letter_id')->unsigned()->index();
            /*
             * %last_1_flight% - first flight from the end
             * %last_2_flight% - second flight from the end
             * %first_1_flight% - first flight from the beginning
             * %last_1_forum% - first forum post from the end
             */
            $table->string('dynamic_content')->nullable();
            $table->integer('content_id')->unsigned()->index()->nullable();
            $table->text('content')->nullable();
            $table->string('location_area')->default('left_sidebar'); // left_sidebar, right_sidebar, left_sidebar_3_col_1, etc.
            $table->integer('sort_order')->default(1);
            $table->timestamps();

            $table->foreign('newsletter_type_id')->references('id')->on('newsletter_types')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('newsletter_letter_id')->references('id')->on('newsletter_letters')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('content_id')->references('id')->on('contents')
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
        Schema::dropIfExists('newsletter_letter_contents');
    }
}
