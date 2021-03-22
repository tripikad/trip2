<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelOfferHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_offer_hotels', function (Blueprint $table) {
            $table->id();
            $table->integer('travel_offer_id')->unsigned()->index();
            $table->string('name');
            $table->float('price');
            $table->integer('star')->nullable();
            $table->string('accommodation')->nullable();
            $table->string('link')->nullable();

            $table->foreign('travel_offer_id')
                ->references('id')
                ->on('travel_offers')
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
        Schema::dropIfExists('travel_offer_hotels');
    }
}
