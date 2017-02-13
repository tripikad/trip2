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
        return config('imagepresets.presets.'.$preset.'.displaypath').$this->filename;
    }

    public static function createImagePresets($path, $filename)
    {
        foreach (array_keys(config('imagepresets.presets')) as $preset) {
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

    public static function storeImageFromUrl($url, $filename = null)
    {
        $path = config('imagepresets.original.path');

        $info = getimagesize($url);
        $ext = image_type_to_extension($info[2], false);

        //create random name
        if (! $filename) {
            $filename = 'image_'.strtolower(str_random(4));
        }

        $filename = self::checkIfExists($path, $filename, $ext);

        try {
            copy($url, $path.$filename);
        } catch (Exception $e) {
            throw new Exception('Image copy failed: '.$e);
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

    public static function checkIfExists($path, $filename, $ext, $i = 0)
    {
        if ($i > 0) {
            $filename = $filename.'-'.$i;
        }

        if (file_exists($path.$filename.'.'.$ext)) {
            ++$i;

            return self::checkIfExists($path, $filename, $ext, $i);
        } else {
            return $filename.'.'.$ext;
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
