<?php

namespace App;

use Cache;
use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\Notifiable as Notifiable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Str;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'role',
        'verified',
        'registration_token',
        'rank',
        'contact_facebook',
        'contact_twitter',
        'contact_instagram',
        'contact_homepage',
        'profile_color',
        'real_name',
        'real_name_show',
        'gender',
        'birthyear',
        'description',
        'notify_message',
        'notify_follow',
        'is_company',
        'company_id'
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $dates = ['created_at', 'updated_at', 'active_at'];

    protected $with = [
        'company'
    ];

    /**
     * @var int in minutes
     */
    public $update_active_at_minutes = 5;

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->registration_token = Str::random(30);
        });
    }

    // Relations

    public function unread_contents()
    {
        return $this->hasMany('App\UnreadContent');
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

    public function images()
    {
        return $this->morphToMany('App\Image', 'imageable');
    }

    public function offers()
    {
        return $this->hasMany('App\Offer');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }

    public function company()
    {
        return $this->hasOne('App\Company', 'id', 'company_id');
    }

    public function update_active_at($force = false, $return = false)
    {
        $last_online = Cache::get('uio-' . $this->id, '0000-00-00 00:00:00');

        if ($last_online == '0000-00-00 00:00:00' || $force) {
            $expires_at = Carbon::now()->addSeconds($this->update_active_at_minutes * 60);

            // uio - user is online :)
            $now = Carbon::now();
            Cache::put('uio-' . $this->id, $now, $expires_at);
            $this->active_at = $now;
            $this->save();
        }

        if ($return) {
            return $this->active_at;
        }
    }

    public $messages_count = false;

    public function confirmEmail()
    {
        $this->verified = true;
        $this->registration_token = null;
        $this->save();
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->remember_token = $token;
        $this->save();
    }

    public function unreadMessages()
    {
        return $this->hasMany('App\Message', 'user_id_to')
            ->where('read', '0');
    }

    public function unreadMessagesCount()
    {
        if ($this->messages_count === false) {
            $this->messages_count = $this->hasMany('App\Message', 'user_id_to')
                ->where('read', '0')
                ->get()
                ->unique('user_id_from')
                ->count();
        }

        return $this->messages_count;
    }

    public function messages()
    {
        $received = $this->hasMany('App\Message', 'user_id_to')
            ->get()
            ->sortByDesc('created_at')
            ->unique('user_id_from')
            ->transform(function ($item) {
                $item->attributes['user_id_with'] = $item->attributes['user_id_from'];

                return $item;
            });

        $sentWithoutReply = $this->hasMany('App\Message', 'user_id_from')
            ->whereNotIn('user_id_to', $received->pluck('user_id_from')->all())
            ->get()
            ->transform(function ($item) {
                $item->attributes['user_id_with'] = $item->attributes['user_id_to'];

                return $item;
            });

        return $received
            ->merge($sentWithoutReply)
            ->sortByDesc('created_at')
            ->all();
    }

    public function messagesWith($user_id_with)
    {
        $sent = $this->hasMany('App\Message', 'user_id_from')
            ->where('user_id_to', $user_id_with)
            ->get();
        $received = $this->hasMany('App\Message', 'user_id_to')
            ->where('user_id_from', $user_id_with)
            ->get();

        return $sent->merge($received)->sortBy('created_at');
    }

    public function imagePreset($preset = 'small_square')
    {
        if ($image = $this->images->first()) {
            return $image->preset($preset);
        }

        return config('imagepresets.image.none');
    }

    public function hasRole($role)
    {
        $roleMap = [
            'regular' => ['regular', 'admin', 'superuser'],
            'admin' => ['admin', 'superuser'],
            'superuser' => ['superuser']
        ];

        return in_array($this->role, $roleMap[$role]);
    }

    public function hasRoleOrOwner($role, $ownable_user_id)
    {
        return $this->hasRole($role) || $ownable_user_id == $this->id;
    }

    public function isCompany()
    {
        return $this->is_company;
    }

    public function destinationHaveBeen()
    {
        return $this->flags->where('flag_type', 'havebeen');
    }

    public function destinationWantsToGo()
    {
        return $this->flags->where('flag_type', 'wantstogo');
    }

    public function likes()
    {
        return $this->flags->where('flag_type', 'good');
    }

    public function updateRanking()
    {
        $contents = $this->contents()
            ->whereNotIn('type', ['buysell', 'internal'])
            ->count();
        $comments = $this->comments()->count();
        $posts = $comments + $contents;
        $have_been = $this->destinationHaveBeen()->count();
        $age = $this->created_at;

        $level = config('user.ranking.starting_level');

        foreach (config('user.ranking.levels') as $rank => $condition) {
            foreach ($condition as $condition => $value) {
                if ($condition === 'countries') {
                    if ($value <= $have_been) {
                        $this->increaseLevel($level);
                    } else {
                        $this->decreaseLevel($level);
                    }
                } elseif ($condition === 'posts') {
                    if ($value <= $posts) {
                        $this->increaseLevel($level);
                    } else {
                        $this->decreaseLevel($level);
                    }
                } elseif ($condition === 'active_time_months') {
                    $created = Carbon::parse($age);
                    $diff = $created->diffInMonths();

                    if ($value <= $diff) {
                        $this->increaseLevel($level);
                    } else {
                        $this->decreaseLevel($level);
                    }
                }

                if ($level === config('user.ranking.starting_level')) {
                    break 2;
                }
            }
        }

        foreach (config('user.ranking.max_level_user_ids') as $user_id) {
            if ($this->id === $user_id) {
                $level = config('user.ranking.max_level');
            }
        }

        $this->update(['rank' => $level]);
    }

    private function increaseLevel(&$level)
    {
        $new_level = $level + 1;
        if ($new_level == config('user.ranking.max_level')) {
            return;
        }

        $ranking = config('user.ranking.levels');
        if (isset($ranking[$new_level])) {
            $level = $new_level;
        }
    }

    private function decreaseLevel(&$level)
    {
        $new_level = $level - 1;
        if ($level == config('user.ranking.starting_level')) {
            return;
        }

        $ranking = config('user.ranking.levels');
        if (isset($ranking[$new_level])) {
            $level = $new_level;
        }
    }

    public function vars()
    {
        return new UserVars($this);
    }
}
