<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

error_reporting(E_NOTICE);

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public function testNewUserRegistration()
    {

        $this->visit('/register')
             ->type('TestKasutaja', 'name')
             ->type('TestKasutaja@test.ee', 'email')
             ->type('salasona', 'password')
             ->type('salasona', 'password_confirmation')
             ->check('eula')
             ->press('Register')
             ->seePageIs('/');

        $this->see(trans('auth.register.sent.status'))
             ->seeInDatabase('users', ['name' => 'TestKasutaja', 'verified' => 0]);


        //name already taken
        $this->visit('/register')
             ->type('TestKasutaja', 'name')
             ->type('TestKasutaja@test.ee', 'email')
             ->type('salasona', 'password')
             ->type('salasona', 'password_confirmation')
             ->check('eula')
             ->press('Register')
             ->seePageIs('/register')
             ->see(trans('validation.unique',['attribute' => 'name']));


        $user = User::whereName('TestKasutaja')->first();

/*
        // You can't login until you confirm your email address.
        // FIXME: For some reason does not work
        $this->visit('/login')
             ->type('TestKasutaja', 'name')
             ->type('salasona', 'password')
             ->press('Login')
             ->seePageIs('/login')
             ->see(trans('login.failed.status'));
             //->see('Failed to log you in');
 */       

/*
        $this->visit("register/confirm/{$user->registration_token}")
             ->seeInDatabase('users', ['name' => 'TestKasutaja', 'verified' => 1]); 
*/
    }

}