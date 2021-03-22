<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelOfferDestinationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_offer_destinations', function (Blueprint $table) {
            $table->id();
            $table
                ->integer('travel_offer_id')
                ->unsigned()
                ->index();
            $table
                ->integer('destination_id')
                ->unsigned()
                ->index();

            $table->foreign('travel_offer_id')
                ->references('id')
                ->on('travel_offers')
                ->onDelete('cascade');

            $table->foreign('destination_id')
                ->references('id')
                ->on('destinations')
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
        Schema::dropIfExists('travel_offer_destinations');
    }
}
