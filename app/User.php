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

    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'role',
        'verified',
        'registration_token',
        'contact_facebook',
        'contact_twitter',
        'contact_instagram',
        'contact_homepage',

        'notify_message',
        'notify_follow'

    ];

    protected $hidden = ['password', 'remember_token'];

    public static function boot()
    {
    
        parent::boot();
    
        static::creating(function ($user) {

            $user->registration_token = str_random(30);
        
        });
    }

    public function confirmEmail()
    {
    
        $this->verified = true;
        $this->registration_token = null;
        $this->save();
    
    }

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

    public function messagesWith($user_id_with)
    {   
        
        $sent = $this->hasMany('App\Message', 'user_id_from')->where('user_id_to', $user_id_with)->get();
        $received = $this->hasMany('App\Message', 'user_id_to')->get();

        return $sent->merge($received)->sortBy('created_at');

    }

    public function contents()
    {
        return $this->hasMany('App\Content');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function flags()
    {
        return $this->hasMany('App\Flag');
    }

    public function follows()
    {
        return $this->hasMany('App\Follow');
    }

    public function imagePath($preset = 'small')
    {
        return $this->image ? '/images/' . $preset . '/' . $this->image : 'http://trip.ee/files/pictures/picture_none.png';
    }

    public function imagePathOnly()
    {
        return $this->image ? '/images/' . $preset . '/' . $this->image : null;
    }

    public function hasRole($role) {
        
        $roleMap = [
            'regular' => ['regular', 'admin', 'superuser'],
            'admin' => ['admin', 'superuser'],
            'superuser' => ['superuser'],
        ];
        
        return in_array($this->role, $roleMap[$role]);

    }

    public function hasRoleOrOwner($role, $ownable_user_id) {

        return ($this->hasRole($role) || $ownable_user_id == $this->id);

    }

    public function destinationHaveBeen()
    {
        return $this->flags->where('flag_type', 'havebeen');
    }

    public function destinationWantsToGo()
    {
        return $this->flags->where('flag_type', 'wantstogo');
    }

}
