<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;

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
            /*
             * %last_0_flight(3)% - latest 3 flights
             * %last_1_flight% - skip 1 flight and after that latest 1 flight
             * %last_1_flight(2)% - skip 1 flight and after that latest 2 flights
             * %first_forum|buysell|expat(5)% - first 5 forum, buysell and expat posts
             * %pop_0_forum|buysell|expat(5)% - 5 popular forum, buysell and expat posts
             * %pop_3_forum|buysell|expat(5)% - Skip 3 first popular posts and after these take 5 popular forum, buysell and expat posts
             */
            $table->string('dynamic_content')->nullable();
            $table->integer('content_id')->unsigned()->index()->nullable();
            $table->text('content')->nullable();
            $table->integer('sort_order')->default(1);
            $table->date('visible_from')->nullable();
            $table->date('visible_to')->nullable();
            $table->timestamps();

            $table->foreign('newsletter_type_id')->references('id')->on('newsletter_types')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('content_id')->references('id')->on('contents')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Artisan::call('db:seed', ['--class' => 'NewsletterLetterContentsSeeder']);
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
