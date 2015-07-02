<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use DB;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    public function messages()
    {   
        
        $received = $this->hasMany('App\Message', 'user_id_to')
            ->get()
            ->sortByDesc('created_at')
            ->unique('user_id');

        $sentWithoutReply = $this->hasMany('App\Message', 'user_id_from')
            ->whereNotIn('user_id_to', $received->pluck('user_id_from')->all())
            ->get();

        return $received->merge($sentWithoutReply)->sortBy('created_at')->all();
    
    }

    public function messagesWith($user_id)
    {   
        
        $sent = $this->hasMany('App\Message', 'user_id_from')->where('user_id_to', $user_id)->get();
        $received = $this->hasMany('App\Message', 'user_id_to')->get();

        return $sent->merge($received)->sortBy('created_at')->all();

    }

    public function follows()
    {
        return $this->hasMany('App\Follow');
    }

    public function imagePath()
    {
        return $this->image ? '/images/user/small/' . $this->image : 'http://trip.ee/files/pictures/picture_none.png';
    }

    public function imagePathOnly()
    {
        return $this->image ? '/images/user/small/' . $this->image : null;
    }

}
