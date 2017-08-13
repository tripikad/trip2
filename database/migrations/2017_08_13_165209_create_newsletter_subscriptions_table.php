<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsletterSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletter_subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('newsletter_type_id')->unsigned()->index();
            $table->integer('user_id')->nullable()->unsigned()->index();
            $table->integer('destination_id')->nullable()->unsigned()->index();
            $table->string('email');
            $table->boolean('active')->default(true);
            $table->timestamp('last_sent_at')->nullable();
            $table->timestamps();

            $table->foreign('newsletter_type_id')->references('id')->on('newsletter_types')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('destination_id')->references('id')->on('destinations')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('newsletter_subscriptions');
    }
}
