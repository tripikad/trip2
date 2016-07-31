<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use App\Content;

class AddSlugToContents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->string('slug');
        });

        Content::chunk(200, function ($contents) {
            /** @var Content $content */
            foreach ($contents as $content) {
                $content->timestamps = false;
                $slug = SlugService::createSlug(Content::class, 'slug', $content->title);
                $content->update(['slug' => $slug]);
            }
        });

        Schema::table('contents', function (Blueprint $table) {
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
