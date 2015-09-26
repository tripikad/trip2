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
    
        return $this->belongsToMany('App\Content');
    
    }

    public function preset($preset = 'small')
    {
        return '/images/' 
            . $preset
            . '/' 
            . $this->filename;
    }


    static public function storeImageFile($file)
    {

        $path = config('imagepresets.original.path');
        $fileName = preg_replace('/\s+/', '-', $file->getClientOriginalName());
        
        $file->move($path, $fileName);

        foreach(array_keys(config('imagepresets.presets')) as $preset) {

            Imageconv::make($path . $fileName)
                ->{config("imagepresets.presets.$preset.operation")}(
                    config("imagepresets.presets.$preset.width"),
                    config("imagepresets.presets.$preset.height"),
                    function ($constraint) {
                        $constraint->aspectRatio();
                })
                ->save(config("imagepresets.presets.$preset.path") . $fileName);

        }

        return $fileName;
    
    }

}
