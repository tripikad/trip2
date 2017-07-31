<?php

namespace Tests\Feature;

use Hash;
use App\User;
use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends BrowserKitTestCase
{
    use DatabaseTransactions;

    public function test_user_can_edit_its_profile()
    {
        $user_editing_profile = factory(User::class)->create();

        $this->actingAs($user_editing_profile)
            //->visit("user/$user_editing_profile->id")
            //->click(trans('menu.user.edit.profile'))
            //->seePageIs("user/$user_editing_profile->id/edit") 
            ->visit("user/$user_editing_profile->id/edit2")
            ->type('manny', 'name')
            ->type('manny@calavera.com', 'email')
            ->type('calavera', 'password')
            ->type('calavera', 'password_confirmation')
            ->type('Manny Calavera', 'real_name')
            ->uncheck('real_name_show')
            ->type('A travel agent at afterworld', 'description')
            ->check('notify_message')
            ->type('http://facebook.com', 'contact_facebook')
            ->type('http://instagram.com', 'contact_instagram')
            ->type('http://twitter.com', 'contact_twitter')
            ->type('http://calavera.com', 'contact_homepage')
            ->press(trans('user.edit.submit'))
            ->seePageIs("user/$user_editing_profile->id") 
            ->see('manny')
            ->see('A travel agent at afterworld')
            ->seeInDatabase('users', [
                'id' => $user_editing_profile->id,
                'name' => 'manny',
                'email' => 'manny@calavera.com',
                'password' => Hash::make('calavera'), // FIXME
                'real_name' => 'Manny Calavera',
                'real_name_show' => 1,
                'notify_message' => 1,
                'contact_facebook' => 'http://facebook.com',
                'contact_instagram' => 'http://instagram.com',
                'contact_twitter' => 'http://twitter.com',
                'contact_homepage' => 'http://calavera.com'
            ]);

    }

    public function test_user_can_upload_profile_image()
    {
        $user1 = factory(User::class)->create();

        $this->actingAs($user1)
            ->visit("user/$user1->id/edit")
            ->attach(storage_path().'/tests/test.jpg', 'image')
            ->press('Submit')
            ->seePageIs("user/$user1->id/edit");

        $filename = $this->getImageFilenameByUserId($user1->id);

        // Check original file exists

        $filepath = config('imagepresets.original.path').$filename;
        $this->assertTrue(file_exists($filepath));
        unlink($filepath);

        // See thumbnails exist

        foreach (['large', 'medium', 'small', 'small_square', 'xsmall_square'] as $preset) {
            $filepath = config("imagepresets.presets.$preset.path").$filename;
            $this->assertTrue(file_exists($filepath));
            unlink($filepath);
        }
    }

    public function getImageFilenameByUserId($id)
    {
        return User::whereId($id)->first()->images[0]->filename;
    }
}
