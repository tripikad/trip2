<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnreadContentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('unread_contents', function (Blueprint $table) {
      $table->increments('id');
      $table
        ->integer('content_id')
        ->index()
        ->unsigned();
      $table
        ->integer('user_id')
        ->index()
        ->unsigned();
      $table
        ->timestamp('read_at')
        ->index()
        ->nullable();

      $table
        ->foreign('content_id')
        ->references('id')
        ->on('contents')
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
    Schema::drop('unread_contents');
  }
}
