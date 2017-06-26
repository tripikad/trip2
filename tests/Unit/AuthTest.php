<?php

namespace Tests\Unit;

use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use Honeypot;
use DB;

class AuthTest extends BrowserKitTestCase
{
    use DatabaseTransactions;

    public function test_user_can_register_confirm_and_login()
    {
        $user = 'test_user_'.date('Ymd');

        Honeypot::disable();

        // User can register

        $this->visit('/')
            ->see(trans('menu.auth.register'))
            ->click(trans('menu.auth.register'))
            ->type($user, 'name')
            ->type('user@example.com', 'email')
            ->type('password', 'password')
            ->type('password', 'password_confirmation')
            ->press(trans('auth.register.submit.title'))
            ->seePageIs('/login')
            ->see(trans('auth.register.sent.info'))
            ->seeInDatabase('users', ['name' => $user, 'verified' => 0]);

        // User with unconfirmed account can not login

        $this->visit('/')
            ->click(trans('menu.auth.login'))
            ->type($user, 'name')
            ->type('password', 'password')
            ->press(trans('auth.login.submit.title'))
            ->seePageIs('/login')
            ->see(trans('auth.login.failed.info'));

        // User can confirm its account

        $this->visit($this->getVerificationLink($user))
            ->seeInDatabase('users', [
                'name' => $user,
                'verified' => 1,
                'registration_token' => null,
            ])
            ->seePageIs('login')
            ->see(trans('auth.register.confirmed.info'));

        // User can log in after confirmation

        $this->visit('/')
            ->click(trans('menu.auth.login'))
            ->type($user, 'name')
            ->type('password', 'password')
            ->press(trans('auth.login.submit.title'))
            ->seePageIs('/');
    }

    public function test_registrered_user_can_reset_password()
    {
        $user = factory(User::class)->create();

        // User can request new password

        Honeypot::disable();

        $this->visit('/')
            ->click(trans('menu.auth.login'))
            ->click(trans('auth.reset.apply.title.link'))
            ->type($user->email, 'email')
            ->press(trans('auth.reset.apply.submit.title'))
            ->seePageIs('/reset/apply')
            ->see(trans('passwords.sent'))
            ->seeInDatabase('password_resets', ['email' => $user->email]);

        // User can confirm new password

        $token = $this->getResetToken($user->email);
        $password = str_random(10);

        $this->visit('/reset/password/'.$token)
            ->type($user->email, 'email')
            ->type($password, 'password')
            ->type($password, 'password_confirmation')
            ->press(trans('auth.reset.password.submit.title'))
            ->seePageIs('/')
            ->notSeeInDatabase('password_resets', [
                'email' => $user->email,
                'token' => $token,
            ])
            //->seeLink(str_limit($user->name, 15), 'user/'.$user->id)
            ->visit('/user/'.$user->id)
            ->seeLink(trans('menu.user.edit.profile'), 'user/'.$user->id.'/edit');
    }

    public function test_nonregistered_user_can_not_reset_password()
    {
        Honeypot::disable();

        $this->visit('/')
            ->click(trans('menu.auth.login'))
            ->click(trans('auth.reset.apply.title.link'))
            ->type('user@example.com', 'email')
            ->press(trans('auth.reset.apply.submit.title'))
            ->seePageIs('/reset/apply')
            ->see(trans('passwords.user'));
    }

    public function getVerificationLink($name)
    {
        $token = User::whereName($name)->first()->registration_token;

        return '/register/confirm/'.$token;
    }

    public function getResetToken($email)
    {
        $token = DB::table('password_resets')->whereEmail($email)->first()->token;

        return $token;
    }
}
