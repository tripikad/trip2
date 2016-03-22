<?php

$images_path = storage_path().'/app/images/';
$svg_path = '/svg/';

return [

    'image' => [
        'none' => $svg_path.'picture_none.svg',
        'path' => $images_path,
    ],

    'original' => [
        'width' => null,
        'height' => null,
        'path' => $images_path.'original/',
    ],

    'presets' => [

        'large' => [
            'operation' => 'resize',
            'width' => 900,
            'height' => null,
            'path' => $images_path.'large/',
            'quality' => 75,
        ],

        'medium' => [
            'operation' => 'resize',
            'width' => 700,
            'height' => null,
            'path' => $images_path.'medium/',
            'quality' => 75,
        ],

        'small' => [
            'operation' => 'resize',
            'width' => 300,
            'height' => null,
            'path' => $images_path.'small/',
            'quality' => 75,
        ],

        'small_square' => [
            'operation' => 'fit',
            'width' => 180,
            'height' => null,
            'path' => $images_path.'small_square/',
            'quality' => 75,
        ],

        'xsmall_square' => [
            'operation' => 'fit',
            'width' => 75,
            'height' => null,
            'path' => $images_path.'xsmall_square/',
            'quality' => 75,
        ],

    ],
];
