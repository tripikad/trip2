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
        $idFrom = 51000;
        $idTo = 51292; //last one imported at the moment 21.12.2021
        $imagesData = DB::table('images')
            ->selectRaw('id, filename, imageables.imageable_id, imageables.imageable_type')
            ->leftjoin('imageables','imageables.image_id','=','images.id')
            ->groupBy('images.id')
            ->orderBy('id', 'ASC')
            ->where('id', '>', $idFrom)
            ->where('id', '<=', $idTo);

        $presets = [
            'xsmall' => 180,
            'small' => 300,
            'medium' => 700,
            'large' => 1024,
            'background' => 1920
        ];

        $allowedImageFormats = ['png', 'jpg', 'jpeg'];

        $imagesData->chunk(50, function($images) use ($presets, $allowedImageFormats) {
            foreach ($images as $image) {
                try {
                    if (Storage::disk('local')->exists('/images/original/' . $image->filename)) {
                        $fileExtension = \File::extension($image->filename);
                        if (!in_array($fileExtension, $allowedImageFormats)) {
                            continue;
                        }

                        $originalPath = storage_path('app') . '/images/original/' . $image->filename;
                        $this->line($originalPath);

                        if ($image->imageable_type === 'App\Content') {
                            Storage::disk('do_spaces')->putFileAs('images/content/original/', $originalPath, $image->filename, 'public');
                            foreach (['xsmall', 'small', 'medium', 'large', 'background'] as $preset) {
                                $spacesSavePath = 'images/content/' . $preset . '/';
                                if ($preset === 'small' || $preset === 'medium') {
                                    $imagePath = storage_path('app') . '/images/' . $preset . '/' . $image->filename;
                                    Storage::disk('do_spaces')->putFileAs($spacesSavePath, $imagePath, $image->filename, 'public');
                                } else {
                                    $resizedImage = \Intervention\Image\Facades\Image::make($originalPath)->resize($presets[$preset], null,
                                        function ($constraint) {
                                            $constraint->aspectRatio();
                                        }
                                    )->encode();

                                    Storage::disk('do_spaces')->put($spacesSavePath . $image->filename, (string) $resizedImage, 'public');
                                }
                            }
                        } else if ($image->imageable_type === 'App\User') {
                            Storage::disk('do_spaces')->putFileAs('images/user_profile/original/', $originalPath, $image->filename, 'public');
                            foreach (['xsmall_square', 'small_square'] as $preset) {
                                $spacesSavePath = 'images/user_profile/' . $preset . '/';
                                $imagePath = storage_path('app') . '/images/' . $preset . '/' . $image->filename;
                                Storage::disk('do_spaces')->putFileAs($spacesSavePath, $imagePath, $image->filename, 'public');
                            }
                        } else {
                            Storage::disk('do_spaces')->putFileAs('images/internal/original/', $originalPath, $image->filename, 'public');
                            foreach (['xsmall', 'small', 'medium', 'large'] as $preset) {
                                $spacesSavePath = 'images/internal/' . $preset . '/';
                                if ($preset === 'small' || $preset === 'medium') {
                                    $imagePath = storage_path('app') . '/images/' . $preset . '/' . $image->filename;
                                    Storage::disk('do_spaces')->putFileAs($spacesSavePath, $imagePath, $image->filename, 'public');
                                } else {
                                    $resizedImage = \Intervention\Image\Facades\Image::make($originalPath)->resize($presets[$preset], null,
                                        function ($constraint) {
                                            $constraint->aspectRatio();
                                        }
                                    )->encode();

                                    Storage::disk('do_spaces')->put($spacesSavePath . $image->filename, (string) $resizedImage, 'public');
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    print_r($image);
                    $this->error($e->getMessage());
                }
            }
        });

        $this->info("\nDone " . $idFrom . ' - ' . $idTo);
        return true;
    }
}
