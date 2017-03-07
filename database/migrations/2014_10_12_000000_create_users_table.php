<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('password', 60);

            $table->string('contact_facebook')->nullable();
            $table->string('contact_twitter')->nullable();
            $table->string('contact_instagram')->nullable();
            $table->string('contact_homepage')->nullable();
            $table->string('profile_color')->default('m-green');
            $table->string('real_name');
            $table->boolean('real_name_show')->default(false);
            $table->integer('gender')->unsigned()->nullable();
            $table->integer('birthyear')->unsigned()->nullable();

            $table->text('description')->nullable();

            $table->boolean('notify_message')->default(false);
            $table->boolean('notify_follow')->default(false);

            $table->string('role')->default('regular');
            $table->integer('rank')->default(0);
            $table->boolean('verified')->default(false);
            $table->string('registration_token')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
