<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public $data;

    public function test_user_can_register_confirm_and_login()
    {
        $this->getFakerData();

        // User can register

        $this->visit('/')
            ->see(trans('menu.auth.register'))
            ->click(trans('menu.auth.register'))
            ->type($this->data['name'], 'name')
            ->type($this->data['email'], 'email')
            ->type($this->data['password'], 'password')
            ->type($this->data['password'], 'password_confirmation')
            ->check('eula')
            ->press(trans('auth.register.submit.title'))
            ->seePageIs('/')
            ->see(trans('auth.register.sent.info'))
            ->seeInDatabase('users', ['name' => $this->data['name'], 'verified' => 0]);

        // User with unconfirmed account can not login

        $this->visit('/')
            ->see(trans('menu.auth.login'))
            ->click(trans('menu.auth.login'))
            ->type($this->data['name'], 'name')
            ->type($this->data['password'], 'password')
            ->press(trans('auth.login.submit.title'))
            ->seePageIs('/login')
            ->see(trans('auth.login.failed.info'));

        // User can confirm its account

        $this->visit($this->getVerificationLink($this->data['name']))
            ->seeInDatabase('users', [
                'name' => $this->data['name'],
                'verified' => 1,
                'registration_token' => null,
            ])
            ->seePageIs('login')
            ->see(trans('auth.register.confirmed.info'));

        // User can log in after confirmation

        $this->visit('/')
            ->click(trans('menu.auth.login'))
            ->type($this->data['name'], 'name')
            ->type($this->data['password'], 'password')
            ->press(trans('auth.login.submit.title'))
            ->seePageIs('/')
            ->see(trans('auth.login.login.info'));
    }

    public function test_user_can_reset_password()
    {
        $this->getFakerData();

        $user1 = factory(App\User::class)->create();

        // user who does not exists in database cannot request new password

        $this->visit('/')
            ->see(trans('menu.auth.login'))
            ->click(trans('menu.auth.login'))
            ->see(trans('auth.reset.apply.title'))
            ->click(trans('auth.reset.apply.title'))
            ->type($this->data['email'], 'email')
            ->see(trans('auth.reset.apply.submit.title'))
            ->press(trans('auth.reset.apply.submit.title'))
            ->seePageIs('/reset/apply')
            ->see(trans('passwords.user'));

        // existed user can request new password

        $this->visit('/')
            ->see(trans('menu.auth.login'))
            ->click(trans('menu.auth.login'))
            ->see(trans('auth.reset.apply.title'))
            ->click(trans('auth.reset.apply.title'))
            ->type($user1->email, 'email')
            ->see(trans('auth.reset.apply.submit.title'))
            ->press(trans('auth.reset.apply.submit.title'))
            ->seePageIs('/')
            ->see(trans('passwords.sent'))
            ->seeInDatabase('password_resets', ['email' => $user1->email]);

        // user can confirm new password

        $reset_token = $this->getResetToken($user1->email);
        $this->visit('/reset/password/'.$reset_token)
            ->type($user1->email, 'email')
            ->type($this->data['password'], 'password')
            ->type($this->data['password'], 'password_confirmation')
            ->see(trans('auth.reset.password.submit.title'))
            ->press(trans('auth.reset.password.submit.title'))
            ->seePageIs('/')
            ->notSeeInDatabase('password_resets', [
                'email' => $user1->email,
                'token' => $reset_token,
            ]);
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

    public function getFakerData()
    {
        $faker = Faker\Factory::create();

        $data = [
            'email' => $faker->email,
            'name' => $faker->userName,
            'password' => $faker->password(10)
        ];

        $this->data = $data;
    }
}
