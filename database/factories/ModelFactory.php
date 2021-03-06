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

use Carbon\Carbon;
use App\User;
use App\Follow;
use App\Comment;
use App\Content;
use App\Message;
use App\Destination;
use App\Offer;

$factory->define(User::class, function ($faker) {
    $name = $faker->name;

    return [
        'name' => $name,
        'email' => $faker->email,
        'password' => bcrypt($name),
        'contact_facebook' => null,
        'contact_twitter' => null,
        'contact_instagram' => null,
        'contact_homepage' => null,
        'gender' => null,
        'birthyear' => null,
        'notify_message' => 0,
        'notify_follow' => 0,
        'role' => 'regular',
        'verified' => 1,
        'registration_token' => '',
        'remember_token' => null
    ];
});

$factory->define(Message::class, function ($faker) {
    return [
        'user_id_from' => 1,
        'user_id_to' => 2,
        'body' => $faker->paragraph(),
        'read' => 1
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

$factory->define(Comment::class, function ($faker) {
    return [
        'user_id' => 1,
        'content_id' => 1,
        'body' => $faker->paragraph(),
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

$factory->define(Destination::class, function ($faker) {
    return [
        'name' => $faker->word(),
        'description' => $faker->paragraph()
    ];
});

$factory->define(Offer::class, function ($faker) {
    return [
        'status' => 1,
        'title' => $faker->sentence(3),
        'style' => 'adventure',
        'start_at' => Carbon::now()->addMonths(2),
        'end_at' => Carbon::now()->addMonths(3),
        'data' => [
            'price' => 1000,
            'guide' => '',
            'size' => '',
            'accommodation' => '',
            'included' => '',
            'notincluded' => '',
            'extras' => '',
            'description' => '',
            'flights' => true,
            'transfer' => true,
            'hotels' => [],
            'url' => ''
        ]
    ];
});

$factory->afterCreating(Offer::class, function ($row, $faker) {
    $startDestination = factory(Destination::class)->create();
    $endDestination = factory(Destination::class)->create();
    $row->startDestinations()->attach([$startDestination->id => ['type' => 'start']]);
    $row->endDestinations()->attach([$endDestination->id => ['type' => 'end']]);
});
