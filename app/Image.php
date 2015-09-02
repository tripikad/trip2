<?php

namespace App;

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
            . $this->content()->first()->type 
            . '/'
            . $preset
            . '/' 
            . $this->filename;
    }

}
