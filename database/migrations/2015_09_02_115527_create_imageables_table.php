<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('imageables', function (Blueprint $table) {
            $table->integer('image_id')->index();
            $table->integer('imageable_id')->index();
            $table->string('imageable_type')->index();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::drop('imageables');
    
    }

}
