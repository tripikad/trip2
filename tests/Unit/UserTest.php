<?php

namespace Tests\Unit;

use App\User;
use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends BrowserKitTestCase
{
    use DatabaseTransactions;

    public function testExample()
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
