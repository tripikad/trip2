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
        $file = config('imagepresets.presets.'.$preset.'.path').$this->filename;

        if (! file_exists(public_path().$file)) {
            $file = '';
        }

        return $file;
    }

    public static function createImagePresets($path, $filename)
    {
        $path = public_path().$path;
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
        $path = public_path().config('imagepresets.original.path');

        $info = getimagesize($url);
        $ext = image_type_to_extension($info[2]);

        //create random name
        if (! $filename) {
            $filename = 'image_'.str_random(5).$ext;
        } else {
            $filename = $filename.$ext;
        }

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
        $path = public_path().config('imagepresets.original.path');

        $ext = $file->guessExtension();

        $filename = $new_filename ? $new_filename : preg_replace('/\s+/', '-', $file->getClientOriginalName());

        if (! $new_filename) {
            $img_name = substr($filename, 0, (strrpos($filename, '.')));
            $filename = $img_name.'_'.str_random(5).'.'.$ext;
        }

        $file->move($path, $filename);

        self::createImagePresets($path, $filename);

        return $filename;
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
