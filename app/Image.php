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

        $fileName = $file->getClientOriginalName();
        $fileName = preg_replace('/\s+/', '-', $fileName);
        $path = config('imagepresets.original.path');
        
        $file->move($path, $fileName);

        Imageconv::make($path . $fileName)
            ->resize(
                config('imagepresets.small.width'),
                config('imagepresets.small.height'),
                function ($constraint) {
                    $constraint->aspectRatio();
            })
            ->save(config('imagepresets.small.path') . $fileName);

        Imageconv::make($path . $fileName)
            ->resize(
                config('imagepresets.medium.width'),
                config('imagepresets.medium.height'),
                function ($constraint) {
                    $constraint->aspectRatio();
            })
            ->save(config('imagepresets.medium.path') . $fileName);

        Imageconv::make($path . $fileName)
            ->resize(
                config('imagepresets.large.width'),
                config('imagepresets.large.height'),
                function ($constraint) {
                    $constraint->aspectRatio();
            })
            ->save(config('imagepresets.large.path') . $fileName);

        return $fileName;
    
    }

}
