<?php

namespace App;

use Imageconv;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['filename'];

    public function content()
    {
        return $this->morphedByMany('App\Content', 'imageable');
    }

    public function user()
    {
        return $this->morphedByMany('App\User', 'imageable');
    }

    public function preset($preset = 'small')
    {
        $original = config('imagepresets.original.displaypath').$this->filename;
        $image = config('imagepresets.presets.'.$preset.'.displaypath').$this->filename;
        $alt_image_real = config('imagepresets.presets.'.$preset.'.path').$this->filename;
        $alt_image = config('imagepresets.presets.'.$preset.'.alt_displaypath').$this->filename;

        if (filter_var($image, FILTER_VALIDATE_URL) && ! config("imagepresets.presets.$preset.on_the_fly")) {
            return $image;
        } elseif (file_exists($alt_image_real)) {
            return $alt_image;
        } elseif (filter_var($image, FILTER_VALIDATE_URL) && config("imagepresets.presets.$preset.on_the_fly")) {
            self::createPresetFromOriginal($original, $this->filename, $preset);

            return $alt_image;
        } elseif (! filter_var($image, FILTER_VALIDATE_URL) && config("imagepresets.presets.$preset.on_the_fly")) {
            self::createPresetFromOriginal($original, $this->filename, $preset);

            return $alt_image;
        } else {
            return $image;
        }
    }

    public static function createImagePresets($path, $filename)
    {
        foreach (array_keys(config('imagepresets.presets')) as $preset) {
            if (! config("imagepresets.presets.$preset.on_the_fly")) {
                Imageconv::make($path.$filename)
                    ->{config("imagepresets.presets.$preset.operation")}(
                        config("imagepresets.presets.$preset.width"),
                        config("imagepresets.presets.$preset.height"),
                        function ($constraint) {
                            $constraint->aspectRatio();
                        })
                    ->save(
                        config("imagepresets.presets.$preset.path").$filename,
                        config("imagepresets.presets.$preset.quality")
                    );
            }
        }
    }

    public static function storeImageFromUrl($url, $filename = null, $trusted = false)
    {
        $path = config('imagepresets.original.path');

        if (! $trusted) {
            $info = getimagesize($url);
            $ext = image_type_to_extension($info[2], false);
        } else {
            $ext = pathinfo($url, PATHINFO_EXTENSION);
        }

        //create random name
        if (! $filename) {
            $filename = 'image_'.strtolower(str_random(4));
        }

        $filename = self::checkIfExists($path, $filename, $ext);

        try {
            copy($url, $path.$filename);
        } catch (\Exception $e) {
            throw new \Exception('Image copy failed: '.$e);
        }

        self::createImagePresets($path, $filename);

        return $filename;
    }

    public static function storeImageFile($file, $new_filename = null)
    {
        $path = config('imagepresets.original.path');

        $ext = $file->guessExtension();

        $filename = $new_filename ? $new_filename : preg_replace('/\s+/', '-', $file->getClientOriginalName());

        if (! $new_filename) {
            $img_name = self::getImageName($filename);
            $filename = $img_name.'_'.strtolower(str_random(4)).'.'.$ext;
        }

        $filename = self::getImageName($filename);
        $filename = self::checkIfExists($path, $filename, $ext);

        $file->move($path, $filename);

        self::createImagePresets($path, $filename);

        return $filename;
    }

    public static function createPresetFromOriginal($original, $image, $preset)
    {
        try {
            if (filter_var($original, FILTER_VALIDATE_URL) && ! file_exists(config('imagepresets.original.path').$image)) {
                self::storeImageFromUrl($original, pathinfo($image, PATHINFO_FILENAME), true);
            }

            $path = config('imagepresets.original.path');

            Imageconv::make($path.$image)
                ->{config("imagepresets.presets.$preset.operation")}(
                    config("imagepresets.presets.$preset.width"),
                    config("imagepresets.presets.$preset.height"))
                ->save(
                    config("imagepresets.presets.$preset.path").$image,
                    config("imagepresets.presets.$preset.quality")
                );
        } catch (\Exception $e) {
        }
    }

    public static function checkIfExists($path, $filename, $ext, $i = 0)
    {
        $new_filename = $filename;

        if ($i > 0) {
            $new_filename = $filename.'-'.$i;
        }

        if (file_exists($path.$new_filename.'.'.$ext)) {
            $i++;

            return self::checkIfExists($path, $filename, $ext, $i);
        } else {
            return $new_filename.'.'.$ext;
        }
    }

    public static function getImageName($file)
    {
        return substr($file, 0, (strrpos($file, '.')));
    }

    public static function getRandom($destination_id = 0)
    {
        if ($destination_id == 0) {
            $featured = config('featured');
            $featured = $featured[array_rand($featured)];
        } else {
            $featured = config('featured.'.$destination_id);

            if (! $featured) {
                return self::getRandom();
            }
        }

        $photo = Content::whereType('photo')->find($featured);

        return $photo ? $photo->imagePreset('large') : null;
    }

    public static function getHeader()
    {
        return '/photos/header3.jpg';
    }

    public static function getFooter()
    {
        return '/photos/footer.jpg';
    }

    public static function getSocial()
    {
        return config('app.url').'photos/social.jpg';
    }
}
