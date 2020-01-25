<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewablesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('viewables', function (Blueprint $table) {
      $table->integer('viewable_id')->index();
      $table->string('viewable_type', 50)->index();
      $table
        ->integer('count')
        ->default(1)
        ->index();

      $table->unique(['viewable_id', 'viewable_type']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('viewables');
  }
}
