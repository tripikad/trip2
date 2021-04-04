<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_offers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id')->index();
            $table->unsignedInteger('start_destination_id')->index();
            $table->unsignedInteger('end_destination_id')->index();
            $table->string('type')->default('package');
            $table->string('name');
            $table->string('slug')->index();
            $table->date('start_date');
            $table->date('end_date');
            $table->float('price');
            $table->boolean('active')->default(false);
            $table->string('link')->nullable();
            $table->text('description')->nullable();
            $table->text('accommodation')->nullable();
            $table->text('included')->nullable();
            $table->text('excluded')->nullable();
            $table->text('extra_fee')->nullable();
            $table->text('extra_info')->nullable();
            $table->json('data')->nullable();
            $table->timestamps();

            $table
                ->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');

            $table->foreign('start_destination_id')
                ->references('id')
                ->on('destinations')
                ->onDelete('cascade');

            $table->foreign('end_destination_id')
                ->references('id')
                ->on('destinations')
                ->onDelete('cascade');

            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travel_offers');
    }
}
