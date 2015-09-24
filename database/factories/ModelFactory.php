<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

use App\User;
use App\Message;
use App\Content;
use App\Follow;

$factory->define(User::class, function ($faker) {
    
    $name = $faker->name;

    return [
        'name' => $name,
        'email' => $faker->email,
        'password' => bcrypt($name),
        'image' => null,
        'contact_facebook' => null,
        'contact_twitter' => null,
        'contact_instagram' => null,
        'contact_homepage' => null,
        'gender' => null,
        'birthyear' => null,
        'notify_message' => 0,
        'notify_follow' => 0,
        'role' => 'regular',
        'verified' => 0,
        'registration_token' => '',
        'remember_token' => null,
    ];

});

$factory->define(Message::class, function ($faker) {
    
    return [
        'user_id_from' => 1,
        'user_id_to' => 2,
        'body' => $faker->paragraph(),
        'read' => 1,
    ];

});

$factory->define(Content::class, function ($faker) {
    
    return [
        'user_id' => 1,
        'title' => $faker->sentence(),
        'body' => $faker->paragraph(),
        'type' => 'forum',
        'status' => 1
    ];

});

$factory->define(Follow::class, function ($faker) {
    
    return [
        'user_id' => 1,
        'followable_id' => 1,
        'followable_type' => 'App\Content'
    ];

});