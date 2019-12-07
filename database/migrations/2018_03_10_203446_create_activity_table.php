<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('activities', function (Blueprint $table) {
      $table->string('ip');
      $table->integer('activity_id');
      $table->string('activity_type', 100)->default('App\\Content');
      $table->string('type', 50)->default('view');
      $table->integer('value')->default(0);
      $table
        ->integer('user_id')
        ->nullable()
        ->index();
      $table->timestamps();

      $table->unique(['ip', 'activity_id', 'activity_type', 'type']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('activities');
  }
}
