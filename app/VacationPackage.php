<?php

namespace App;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable as Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers as SlugHelper;
use Illuminate\Database\Eloquent\Model;

class VacationPackage extends Model
{
    use Sluggable, SlugHelper;

    protected $table = 'vacation_packages';

    protected $fillable = ['name'];

    protected $dates = ['created_at', 'updated_at'];

    protected $appends = [
        'status',
        'small_image',
        'medium_image',
        'background_image'
    ];

    protected $casts = [
        'active' => 'boolean',
        'data' => 'array'
    ];

    protected $with = [
        'company',
        'image'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function short_description()
    {
        return mb_strimwidth(strip_tags($this->description), 0, 100, "...");
    }

    public function company()
    {
        return $this->hasOne('App\Company', 'id', 'company_id');
    }

    public function vacationPackageCategories()
    {
        return $this->belongsToMany('App\VacationPackageCategory', 'vacation_package_category_map');
    }

    public function image()
    {
        return $this->hasOne('App\Image', 'id', 'image_id');
    }

    public function getSmallImageAttribute()
    {
        $image = $this->image;
        return $image->preset('small');
    }

    public function getMediumImageAttribute()
    {
        $image = $this->image;
        return $image->preset('medium');
    }

    public function getBackgroundImageAttribute()
    {
        $image = $this->image;
        return $image->preset('background');
    }

    public function getVacationPackageCategoryNames()
    {
        if ($this->relationLoaded('vacationPackageCategories')) {
            $values = $this->vacationPackageCategories->pluck('name')->toArray();
            return implode(', ', $values);
        }

        return false;
    }

    public function getStatusAttribute()
    {
        if ($this->end_date < Carbon::today()->toDateString()) {
            return 'expired';
        } else if ($this->active === true) {
            return 'active';
        } else {
            return 'draft';
        }
    }
}

