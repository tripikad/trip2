<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsletterSentSubscribersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('newsletter_sent_subscribers', function (Blueprint $table) {
      $table->increments('id');
      $table
        ->integer('subscription_id')
        ->nullable()
        ->unsigned()
        ->index();
      $table
        ->integer('sent_id')
        ->unsigned()
        ->index();
      $table
        ->integer('user_id')
        ->nullable()
        ->unsigned()
        ->index();
      $table
        ->boolean('sending')
        ->default(1)
        ->index();
      $table->timestamps();

      $table
        ->foreign('subscription_id')
        ->references('id')
        ->on('newsletter_subscriptions')
        ->onUpdate('cascade')
        ->onDelete('cascade');

      $table
        ->foreign('sent_id')
        ->references('id')
        ->on('newsletter_sents')
        ->onUpdate('cascade')
        ->onDelete('cascade');

      $table
        ->foreign('user_id')
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
    Schema::dropIfExists('newsletter_sent_subscribers');
  }
}
