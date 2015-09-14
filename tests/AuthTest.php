<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_can_register()
    {

        $this->visit('/')
            ->see(trans('menu.header.register'))
            ->click(trans('menu.header.register'))
            ->type('user', 'name')
            ->type('user@example.com', 'email')
            ->type('password', 'password')
            ->type('password', 'password_confirmation')
            ->check('eula')
            ->press(trans('auth.register.submit.title'))
            ->seePageIs('/')
            ->see(trans('auth.register.sent.info'))
            ->seeInDatabase('users', ['name' => 'user', 'verified' => 0]);

        $this->visit('/')
            ->click(trans('menu.header.login'))
            ->type('user', 'name')
            ->type('user', 'password')
            ->press(trans('auth.login.submit.title'))
            ->seePageIs('/login')
            ->see(trans('auth.login.failed.info'));

        $this->visit($this->getVerificationLink('user'))
            ->seePageIs('login')
            ->see(trans('auth.register.confirmed.info'));


    }

    public function test_user_can_login()
    {

        $user = factory(App\User::class)->create([
            'verified' => 1,
            'registration_token' => null,
        ]);

        $this->visit('/')
            ->seeLink(trans('menu.header.login'))
            ->click(trans('menu.header.login'))
            ->type($user->name, 'name')
            ->type($user->name, 'password')
            ->press(trans('auth.login.submit.title'))
            ->seePageIs('/')
            ->see(trans('auth.login.login.info'))
            ->see(trans('menu.header.logout'));

    }

    public function getVerificationLink($name) {

        $token = User::whereName($name)->first()->registration_token;

        return '/register/confirm/' . $token;
    }


}