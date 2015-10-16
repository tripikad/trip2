<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_can_register_confirm_and_login()
    {

        // User can register

        $this->visit('/')
            ->see(trans('menu.auth.register'))
            ->click(trans('menu.auth.register'))
            ->type('user', 'name')
            ->type('user@example.com', 'email')
            ->type('password', 'password')
            ->type('password', 'password_confirmation')
            ->check('eula')
            ->press(trans('auth.register.submit.title'))
            ->seePageIs('/')
            ->see(trans('auth.register.sent.info'))
            ->seeInDatabase('users', ['name' => 'user', 'verified' => 0]);

        // User with unconfirmed account can not login

        $this->visit('/')
            ->click(trans('menu.auth.login'))
            ->type('user', 'name')
            ->type('password', 'password')
            ->press(trans('auth.login.submit.title'))
            ->seePageIs('/login')
            ->see(trans('auth.login.failed.info'));

        // User can confirm its account

        $this->visit($this->getVerificationLink('user'))
            ->seeInDatabase('users', [
                'name' => 'user',
                'verified' => 1,
                'registration_token' => null,
            ])
            ->seePageIs('login')
            ->see(trans('auth.register.confirmed.info'));

        // User can log in after confirmation

        $this->visit('/')
            ->click(trans('menu.auth.login'))
            ->type('user', 'name')
            ->type('password', 'password')
            ->press(trans('auth.login.submit.title'))
            ->seePageIs('/')
            ->see(trans('auth.login.login.info'));
    }

    public function getVerificationLink($name)
    {
        $token = User::whereName($name)->first()->registration_token;

        return '/register/confirm/'.$token;
    }
}
