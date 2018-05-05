<?php

function formatBytes($size, $precision = 3)
{
    $base = log($size, 1024);
    $suffixes = array('', 'K', 'M', 'G', 'T');

    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
}


function filepath($name, $width, $quality = 75, $step1 = null, $step2 = null) {
    $filename = collect([$name,'w'.$width,'q'.$quality,$step1,$step2])
        ->reject(function ($name) {
            return empty($name);
        })
        ->implode('_');
    return storage_path('tmp/'.$filename.'.jpeg');
}

Artisan::command('image:list {name}', function ($name) {
    $files = collect(Storage::disk('root')->files('storage/tmp/'))
        ->filter(function($filepath) use ($name) {
            return starts_with(basename($filepath), $name);
        })
        ->map(function($filepath) {
            $filename = basename($filepath);
            return [
                'name' => basename($filepath),
                'size' => formatBytes(Storage::disk('root')->size($filepath))
            ];
        });
    $this->table(['name', 'size'], $files->reverse());
});

Artisan::command('image:resize {name}', function ($name) {
    
    $presets = [
        ['w' => 900, 'h' => null, 'op' => 'resize'],
        ['w' => 700, 'h' => null, 'op' => 'resize'],
        ['w' => 300, 'h' => null, 'op' => 'resize'],
        ['w' => 180, 'h' => null, 'op' => 'fit'],
        ['w' => 75, 'h' => null, 'op' => 'fit'],
        ['w' => 420, 'h' => 260, 'op' => 'fit'],
    ];

    collect($presets)->each(function($preset) use ($name) {
        
        $image = Imageconv::make(storage_path('tmp/'.$name.'.jpeg'));

        $image->{$preset['op']}($preset['w'], $preset['h'], function ($constraint) {
            $constraint->aspectRatio();
        });
        
        $image->save(filepath($name, $preset['w'], 75), 75);

        ImageOptimizer::optimize(
            filepath($name, $preset['w']),
            filepath($name, $preset['w'], 75, 'opt')
        );

        Imageconv::make(filepath($name, $preset['w'], 75, 'opt'))
            ->sharpen(3)
            ->save(filepath($name, $preset['w'], 75, 'opt','sharp'));

    });

});
/*
Artisan::command('image:resize {from} {to=""} {width=""} {quality=100}', function ($from, $to, $width, $quality) {
    
    $fromImage = Imageconv::make(storage_path('tmp/'.$from.'.jpeg'));

    $rows = [];

    $rows[] = [
        'original',
        $fromImage->width(),
        100,
        bytes($fromImage->filesize())
    ];

    $fromImage->resize(900, null, function ($constraint) {
        $constraint->aspectRatio();
    })
    ->save(storage_path('tmp/'.$from.'_900_q95.jpeg'), 95);

    $rows[] = [
        'resize',
        $fromImage->width(),
        95,
        bytes($fromImage->filesize())
    ];

    $fromImage = Imageconv::make(storage_path('tmp/'.$from.'.jpeg'));

    $fromImage->resize(900, null, function ($constraint) {
        $constraint->aspectRatio();
    })
    ->save(storage_path('tmp/'.$from.'_900_q75.jpeg'), 75);

    $rows[] = [
        'resize',
        $fromImage->width(),
        75,
        bytes($fromImage->filesize())
    ];

    ImageOptimizer::optimize(
        storage_path('tmp/'.$from.'_900_q95.jpeg'),
        storage_path('tmp/'.$from.'_900_q95_o75.jpeg')
    );

    $image = Imageconv::make(storage_path('tmp/'.$from.'_900_q95_o75.jpeg'))->sharpen(10);
    $rows[] = [
        'resize → optimize',
        $image->width(),
        '95 → 75',
        bytes($image->filesize())
    ];

    $image = Imageconv::make(storage_path('tmp/'.$from.'_900_q95_o75.jpeg'))
        ->sharpen(5)
        ->save(storage_path('tmp/'.$from.'_900_q95_o75_sharp.jpeg'));

    $this->table(['name','width', 'quality', 'size'], $rows);

});
*/