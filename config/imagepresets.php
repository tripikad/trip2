<?php

$images_path = storage_path().'/app/images/';
$images_displaypath = env('IMAGE_PATH', '/images/');
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
        'displaypath' => $images_displaypath.'original/',
    ],

    'presets' => [

        'large' => [
            'operation' => 'resize',
            'width' => 900,
            'height' => null,
            'path' => $images_path.'large/',
            'displaypath' => $images_displaypath.'large/',
            'quality' => 75,
        ],

        'medium' => [
            'operation' => 'resize',
            'width' => 700,
            'height' => null,
            'path' => $images_path.'medium/',
            'displaypath' => $images_displaypath.'medium/',
            'quality' => 75,
        ],

        'small' => [
            'operation' => 'resize',
            'width' => 300,
            'height' => null,
            'path' => $images_path.'small/',
            'displaypath' => $images_displaypath.'small/',
            'quality' => 75,
        ],

        'small_square' => [
            'operation' => 'fit',
            'width' => 180,
            'height' => null,
            'path' => $images_path.'small_square/',
            'displaypath' => $images_displaypath.'small_square/',
            'quality' => 75,
        ],

        'xsmall_square' => [
            'operation' => 'fit',
            'width' => 75,
            'height' => null,
            'path' => $images_path.'xsmall_square/',
            'displaypath' => $images_displaypath.'xsmall_square/',
            'quality' => 75,
        ],

    ],
];
