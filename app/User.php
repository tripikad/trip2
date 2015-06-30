<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    public function messages()
    {
        return $this->hasMany('App\Message', 'user_id_to');
    }

    public function follows()
    {
        return $this->hasMany('App\Follow');
    }

    public function imagePath()
    {
        return $this->image ? '/images/user/' . $this->image : 'http://trip.ee/files/pictures/picture_none.png';
    }

    public function imagePathOnly()
    {
        return $this->image ? '/images/user/' . $this->image : null;
    }

}
