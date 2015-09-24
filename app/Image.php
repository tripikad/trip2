<?php

namespace App;
use Imageconv;

use Illuminate\Database\Eloquent\Model;

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

    public static function storeImage($file)
    {

        $fileName = $file->getClientOriginalName();
        $fileName = preg_replace('/\s+/', '-', $fileName);
        $path = public_path() . "/images/original/";
        
        $smallPath = public_path() . "/images/small/";
        $mediumPath = public_path() . "/images/medium/";
        $largePath = public_path() . "/images/large/";
        
        $file->move($path, $fileName);

        Imageconv::make($path . $fileName)
            ->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save($smallPath . $fileName);

        Imageconv::make($path . $fileName)
            ->resize(700, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save($mediumPath . $fileName);

        Imageconv::make($path . $fileName)
            ->resize(900, null, function ($constraint) {
                $constraint->aspectRatio();
            })
            ->save($largePath . $fileName);

        return $fileName;
    
    }

}
