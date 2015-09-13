<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public function testNewUserRegistration()
    {

        $this->visit('/register')
             ->type('testuser', 'name')
             ->type('testuser@example.com', 'email')
             ->type('password', 'password')
             ->type('password', 'password_confirmation')
             ->check('eula')
             ->press('Register')
             ->seePageIs('/');

        $this->see(trans('auth.register.sent.info'))
             ->seeInDatabase('users', ['name' => 'testuser', 'verified' => 0]);

        //name already taken

        $this->visit('/register')
             ->type('testuser', 'name')
             ->type('testuser@example.com', 'email')
             ->type('password', 'password')
             ->type('password', 'password_confirmation')
             ->check('eula')
             ->press('Register')
             ->seePageIs('/register')
             ->see(trans('validation.unique',['attribute' => 'name']));


        $user = User::whereName('testuser')->first();

/*
        // You can't login until you confirm your email address.
        // FIXME: For some reason does not work
        $this->visit('/login')
             ->type('TestKasutaja', 'name')
             ->type('salasona', 'password')
             ->press('Login')
             ->seePageIs('/login')
             ->see(trans('login.failed.info'));
             //->see('Failed to log you in');

        $this->visit("register/confirm/{$user->registration_token}")
             ->seeInDatabase('users', ['name' => 'TestKasutaja', 'verified' => 1]); 
*/

    }

}