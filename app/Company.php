<?php

namespace App;

use Carbon\Carbon;
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

    public function vacationPackages()
    {
        return $this->hasMany('App\VacationPackage');
    }

    public function activeVacationPackages()
    {
        return $this->vacationPackages()
            ->where('active', true)
            ->where('end_date', '>=', Carbon::today()->toDateString());
    }

    public function canActivateVacationPackage()
    {
        $count = $this->activeVacationPackages()->count();
        $subscription = $this->user->activeSubscription;

        //todo: temporary atm
        return $count <= 2;

        if (!$subscription) {
            return false;
        }

        $plan = $subscription->plan;
        return $count < (int)$plan->name; //plan name is number
    }

    public function images()
    {
        return $this->morphToMany('App\Image', 'imageable');
    }
}

