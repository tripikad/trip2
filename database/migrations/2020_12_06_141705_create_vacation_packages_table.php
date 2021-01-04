<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacationPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacation_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('company_id')->index();
            $table->string('name');
            $table->string('slug')->index();
            $table->date('start_date');
            $table->date('end_date');
            $table->float('price');
            $table->boolean('active')->default(false);
            $table->text('description');
            $table->string('link');
            $table->unsignedInteger('image_id')->index();
            $table->json('data')->nullable();
            $table->timestamps();

            $table
                ->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');

            $table
                ->foreign('image_id')
                ->references('id')
                ->on('images');

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
        Schema::dropIfExists('vacation_packages');
    }
}
