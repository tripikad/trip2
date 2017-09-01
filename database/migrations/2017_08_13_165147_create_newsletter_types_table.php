<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsletterTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletter_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject'); // Mis toimus Tripis möödunud nädalal? | Pole Sind ammu näinud | Leidsime Sulle sobiva Lennupakkumise sihtkohta %destination_name
            $table->string('type', 50)->nullable()->index(); // flight | weekly | long_time_ago
            $table->integer('send_days_after')->nullable(); // flight = NULL | Nädala uudiskiri = 7 | Pole ammu näinud = 30?
            $table->boolean('check_user_active_at')->default(false); // Pole ammu näinud = true
            $table->timestamp('last_sent_at')->nullable();
            $table->timestamp('send_at')->nullable(); // flight = NULL | Pole ammu näinud = NULL | next timestamp
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Artisan::call('db:seed', ['--class' => 'NewsletterTypesSeeder']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('newsletter_types');
    }
}
