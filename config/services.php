<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => '',
        'secret' => '',
    ],

    'mandrill' => [
        'secret' => '',
    ],

    'ses' => [
        'key' => '',
        'secret' => '',
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key' => '',
        'secret' => '',
    ],

    //Socialite
    'facebook' => [
        'client_id' => '1675459002689506',
        'client_secret' => 'de6f30f98d29f43e254c46723c051c52',
        'redirect' => url().'/facebook',
    ],

    'google' => [
        'client_id' => '748880247677-3tf603jmjia9c75armb2tcf4grqbcrrv.apps.googleusercontent.com',
        'client_secret' => '8_cqTGja0KCGrx_gAb1wQryq',
        'redirect' => url().'/google',
    ],

];
