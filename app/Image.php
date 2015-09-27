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
        return '/images/' 
            . $preset
            . '/' 
            . $this->filename;
    }


    static public function storeImageFile($file, $new_filename = null)
    {

        $path = config('imagepresets.original.path');
        $filename = $new_filename ? $new_filename : preg_replace('/\s+/', '-', $file->getClientOriginalName());
        
        $file->move($path, $filename);

        foreach(array_keys(config('imagepresets.presets')) as $preset) {

            Imageconv::make($path . $filename)
                ->{config("imagepresets.presets.$preset.operation")}(
                    config("imagepresets.presets.$preset.width"),
                    config("imagepresets.presets.$preset.height"),
                    function ($constraint) {
                        $constraint->aspectRatio();
                })
                ->save(
                    config("imagepresets.presets.$preset.path") . $filename,
                    config("imagepresets.presets.$preset.quality")
                );

        }

        return $filename;
    
    }

}
