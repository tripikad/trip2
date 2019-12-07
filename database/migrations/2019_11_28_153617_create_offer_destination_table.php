<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfferDestinationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_destination', function (Blueprint $table) {
            $table->increments('id');
            $table
        ->integer('offer_id')
        ->unsigned()
        ->index();
            $table
        ->integer('destination_id')
        ->unsigned()
        ->index();
            $table->string('type', 20)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer_destination');
    }
}
