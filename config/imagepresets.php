<?php

$prepath = storage_path() . '/app/images/';

return [

    'original' => [
        'width' => null,
        'height' => null,
        'path' => $prepath.'original/',
    ],

    'presets' => [

        'large' => [
            'operation' => 'resize',
            'width' => 900,
            'height' => null,
            'path' => $prepath.'large/',
            'quality' => 75,
        ],

        'medium' => [
            'operation' => 'resize',
            'width' => 700,
            'height' => null,
            'path' => $prepath.'medium/',
            'quality' => 75,
        ],

        'small' => [
            'operation' => 'resize',
            'width' => 300,
            'height' => null,
            'path' => $prepath.'small/',
            'quality' => 75,
        ],

        'small_square' => [
            'operation' => 'fit',
            'width' => 180,
            'height' => null,
            'path' => $prepath.'small_square/',
            'quality' => 75,
        ],

        'xsmall_square' => [
            'operation' => 'fit',
            'width' => 75,
            'height' => null,
            'path' => $prepath.'xsmall_square/',
            'quality' => 75,
        ],

    ],
];
