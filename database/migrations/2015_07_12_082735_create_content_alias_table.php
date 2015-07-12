<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentAliasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    
        Schema::create('content_alias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('content_id')->index();
            $table->string('alias');
        });
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('content_alias');
    }
}
