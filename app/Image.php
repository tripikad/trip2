<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Imageconv;

class Image extends Model
{
    protected $fillable = ['filename'];

    public $timestamps = false;

    public function content()
    {
        return $this->morphedByMany('App\Content', 'imageable');
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
            $filename = 'image_'.str_random(5);
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
            $filename = $img_name.'_'.str_random(5).'.'.$ext;
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

    public static function getRandom()
    {
        $photo = Content::whereType('photo')
            ->orderByRaw('RAND()')
            ->first();

        return $photo ? $photo->imagePreset('large') : null;
    }

    public static function getAllContentExcept($except = null)
    {
        if (! is_array($except)) {
            $except = [
                'contents.type' => $except,
            ];
        }

        $images = self::whereNotIn('id', function ($query) use ($except) {
                $whereType = 'orWhere';

                $query->from('imageables')
                    ->select('imageables.image_id');

                $query->leftJoin('contents', 'imageables.imageable_id', '=', 'contents.id');

                if (isset($except['contents.type'])) {
                    $query->where('contents.type', '=', $except['contents.type']);
                } elseif (isset($except['imageable_type'])) {
                    $whereType = 'where';
                }

                if (isset($except['imageable_type'])) {
                    $query->$whereType('imageables.imageable_type', '!=', $except['imageable_type']);
                }
            })
            ->orderBy('id', 'asc');

        return $images ? $images : null;
    }
}
