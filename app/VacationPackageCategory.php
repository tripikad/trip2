<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VacationPackageCategory extends Model
{
    protected $table = 'vacation_package_categories';

    public $timestamps = false;

    public function vacationPackage()
    {
        return $this->belongsToMany('App\VacationPackage', 'vacation_package_category_map');
    }
}
