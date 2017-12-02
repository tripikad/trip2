<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\User;
use App\Content;

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
            'title' => 'test121212',
            'body' => 'test',
            'type' => 'forum',
            'user_id' => 1,
            'meta' => collect()->put('hello', 'world'),
        ]);

        dump(Content::whereTitle('test121212')->first()->meta);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('contents', function (Blueprint $table) {
        //     $table->dropColumn('meta');
        // });
    }
}
