<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
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
            $table->integer('newsletter_type_id')->unsigned()->index();
            /*
             * [[type:flight|take:3]] - latest 3 flights
             * [[type:flight|skip:1|take:1]] - skip 1 flight and after that latest 1 flight
             * [[type:flight|skip:1|take:2]] - skip 1 flight and after that latest 2 flights
             * [[type:forum,buysell,expat|take:5|order_by:created_at,asc]] - first 5 forum, buysell and expat posts
             * [[type:forum,buysell,expat|take:5|order_by:pop]] - 5 popular forum, buysell and expat posts
             * [[type:forum,buysell,expat|skip:3|take:5|order_by:pop]] - Skip 3 first popular posts and after these take 5 popular forum, buysell and expat posts
             */
            $table->text('body');
            $table->integer('sort_order')->default(1);
            $table->date('visible_from')->nullable();
            $table->date('visible_to')->nullable();
            $table->timestamps();

            $table->foreign('newsletter_type_id')->references('id')->on('newsletter_types')
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
