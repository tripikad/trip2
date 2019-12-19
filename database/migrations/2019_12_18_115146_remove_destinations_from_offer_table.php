<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveDestinationsFromOfferTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('offers', function (Blueprint $table) {
      $table->dropColumn('start_destination_id');
      $table->dropColumn('end_destination_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('offers', function (Blueprint $table) {
      $table
        ->integer('start_destination_id')
        ->unsigned()
        ->index();
      $table
        ->integer('end_destination_id')
        ->unsigned()
        ->index();
    });
  }
}
