<?php

$images_path = storage_path() . '/app/images/';
$images_alt_displaypath = '/images/';
$images_displaypath = env('IMAGE_PATH', $images_alt_displaypath);
$svg_path = '/photos/';

return [
    'image' => [
        'none' => $svg_path . 'picture_none.svg',
        'path' => $images_path
    ],

    'original' => [
        'width' => null,
        'height' => null,
        'path' => $images_path . 'original/',
        'displaypath' => $images_displaypath . 'original/',
        'alt_displaypath' => $images_alt_displaypath . 'original/'
    ],

    'presets' => [
        'background' => [
            'on_the_fly' => false,
            'operation' => 'resize',
            'width' => 1440,
            'height' => null,
            'path' => $images_path . 'background/',
            'displaypath' => $images_displaypath . 'background/',
            'alt_displaypath' => $images_alt_displaypath . 'background/',
            'quality' => 100
        ],

        'large' => [
            'on_the_fly' => false,
            'operation' => 'resize',
            'width' => 900,
            'height' => null,
            'path' => $images_path . 'large/',
            'displaypath' => $images_displaypath . 'large/',
            'alt_displaypath' => $images_alt_displaypath . 'large/',
            'quality' => 75
        ],

        'medium' => [
            'on_the_fly' => false,
            'operation' => 'resize',
            'width' => 700,
            'height' => null,
            'path' => $images_path . 'medium/',
            'displaypath' => $images_displaypath . 'medium/',
            'alt_displaypath' => $images_alt_displaypath . 'medium/',
            'quality' => 75
        ],

        'small' => [
            'on_the_fly' => false,
            'operation' => 'resize',
            'width' => 300,
            'height' => null,
            'path' => $images_path . 'small/',
            'displaypath' => $images_displaypath . 'small/',
            'alt_displaypath' => $images_alt_displaypath . 'small/',
            'quality' => 75
        ],

        'small_square' => [
            'on_the_fly' => false,
            'operation' => 'fit',
            'width' => 180,
            'height' => null,
            'path' => $images_path . 'small_square/',
            'displaypath' => $images_displaypath . 'small_square/',
            'alt_displaypath' => $images_alt_displaypath . 'small_square/',
            'quality' => 75
        ],

        'xsmall_square' => [
            'on_the_fly' => false,
            'operation' => 'fit',
            'width' => 75,
            'height' => null,
            'path' => $images_path . 'xsmall_square/',
            'displaypath' => $images_displaypath . 'xsmall_square/',
            'alt_displaypath' => $images_alt_displaypath . 'xsmall_square/',
            'quality' => 75
        ],

        'small_fit' => [
            'on_the_fly' => true,
            'operation' => 'crop',
            'width' => 420,
            'height' => 260,
            'path' => $images_path . 'small_fit/',
            'displaypath' => $images_displaypath . 'small_fit/',
            'alt_displaypath' => $images_alt_displaypath . 'small_fit/',
            'quality' => 100
        ]
    ]
];
