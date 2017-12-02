<?php

use App\User;
use App\Content;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMetaToContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->json('meta')->nullable();
        });

        User::create([
            'name' => 'test',
        ]);

        Content::create([
            'id' => '10000000',
            'title' => 'test',
            'body' => 'test',
            'user_id' => 1,
            'meta' => collect()->put('hello', 'world'),
        ]);

        dump(Content::findOrFail(10000000)->meta);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropColumn('meta');
        });
    }
}
