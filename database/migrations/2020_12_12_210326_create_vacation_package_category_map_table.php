<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacationPackageCategoryMapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacation_package_category_map', function (Blueprint $table) {
            $table->id();
            $table
                ->integer('vacation_package_id')
                ->unsigned()
                ->index();
            $table
                ->integer('vacation_package_category_id')
                ->unsigned()
                ->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacation_package_category_map');
    }
}
