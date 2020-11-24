<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable as Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers as SlugHelper;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use Sluggable, SlugHelper;

    protected $table = 'companies';

    protected $fillable = ['name'];

    protected $dates = ['created_at', 'updated_at'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function user()
    {
        return $this->hasOne('App\User', 'company_id', 'id');
    }
}

