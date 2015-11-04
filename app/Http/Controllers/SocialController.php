<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Image;
use Socialite;

class SocialController extends Controller
{
    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function facebook()
    {
        try {
            $user = Socialite::driver('facebook')->user();
        } catch (Exception $e) {
            return redirect()->route('login.form')->with('info', trans('auth.login.facebook.service.error'));
        }

        $authUser = $this->findOrCreateUser($user, 'facebook');

        if ($authUser) {
            Auth::login($authUser, true);

            return redirect()->route('frontpage.index')->with('info', trans('auth.login.login.info'));
        } else {
            return redirect()->route('register.form')->with('info', trans('auth.login.facebook.user.error'));
        }
    }

    public function google()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (Exception $e) {
            return redirect()->route('login.form')->with('info', trans('auth.login.google.service.error'));
        }

        $authUser = $this->findOrCreateUser($user, 'google');

        if ($authUser) {
            Auth::login($authUser, true);

            return redirect()->route('frontpage.index')->with('info', trans('auth.login.login.info'));
        } else {
            return redirect()->route('register.form')->with('info', trans('auth.login.google.user.error'));
        }
    }

    protected function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('email', $user->email)->first();
        $avatar_url = null;

        if ($authUser) {
            return $authUser;
        }

        $new_user = User::create([
            'name'     => $user->name,
            'email'    => $user->email,
            'verified' => 1,
            'role'     => 'regular',
            'password' => str_random(30),
        ]);

        switch ($provider) {
            case 'facebook': $avatar_url = $user->avatar_original; break;
            case 'google'  : $avatar_url = str_replace('?sz=50', '', $user->avatar); break;
        }

        //has avatar picture
        if ($avatar_url) {
            $img_name = 'user-'.$new_user->id;
            $filename = Image::storeImageFromUrl((string) $avatar_url, $img_name);
            $new_user->images()->create(['filename' => $filename]);
        }

        return $new_user;
    }
}
