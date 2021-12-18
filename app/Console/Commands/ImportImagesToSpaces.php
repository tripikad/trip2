<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImportImagesToSpaces extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:imagesToSpaces';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports images to digitalocean spaces';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $images = DB::table('images')
            ->selectRaw('id, filename, imageables.imageable_id, imageables.imageable_type')
            ->leftjoin('imageables','imageables.image_id','=','images.id')
            ->groupBy('images.id')
            ->orderBy('id', 'DESC')
            ->take(5)
            ->get();

        foreach ($images as $image) {
            if (Storage::disk('local')->exists('/images/original/' . $image->filename)) {
                $SpacesStoragePath = 'internal';
                $imagePath = storage_path('app') . '/images/original/' . $image->filename;
                if ($image->imageable_type === 'App\Content') {
                    $SpacesStoragePath = 'content';

                    /*foreach (['small'] as $preset) {
                        if (!config("imagepresets.presets.$preset.on_the_fly")) {
                            \Intervention\Image\Facades\Image::make($path . $filename)
                                ->{config("imagepresets.presets.$preset.operation")}(
                                    config("imagepresets.presets.$preset.width"),
                                    config("imagepresets.presets.$preset.height"),
                                    function ($constraint) {
                                        $constraint->aspectRatio();
                                    }
                                )
                                ->save(
                                    config("imagepresets.presets.$preset.path") . $filename,
                                    config("imagepresets.presets.$preset.quality")
                                );
                        }
                    }*/

                } else if ($image->imageable_type === 'App\User') {
                    $SpacesStoragePath = 'user_profile';
                }

                Storage::disk('do_spaces')->putFileAs('images/' . $SpacesStoragePath, $imagePath, $image->filename, 'public');
            }
        }

        //print_r($images);

        $this->info("\nDone");
    }
}
