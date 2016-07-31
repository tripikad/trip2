<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use App\Destination;

class AddSlugToDestinations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->string('slug');
        });

        Destination::chunk(200, function ($destinations) {
            /** @var Destination destination */
            foreach ($destinations as $destination) {
                $slug = SlugService::createSlug(Destination::class, 'slug', $destination->name);
                $destination->update(['slug' => $slug]);
            }
        });

        Schema::table('destinations', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
