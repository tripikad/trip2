<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Content;

class PhotoTest extends TestCase
{
    use DatabaseTransactions;

    public function test_regular_user_can_post_photos()
    {

        $user1 = factory(App\User::class)->create();

        $this->actingAs($user1)
            ->visit('content/photo')
            ->seeLink(trans('content.photo.create.title'))
            ->click(trans('content.photo.create.title'))
            ->seePageIs('content/photo/create')
            ->type('Test image', 'title')
            ->attach(storage_path() . '/tests/test.jpg', 'file')
            ->press(trans('content.create.submit.title'))
            ->seePageIs('content/photo')
            ->see(trans('content.store.status.1.info', ['title' => 'Test image']))
            ->see('Test image');

        $filename = $this->getImageFilenameByTitle('Test image');
        
        // Check original file exists

        $filepath = config('imagepresets.original.path') . $filename;
        $this->assertTrue(file_exists($filepath));
        unlink($filepath);

        // See thumbnails exist

        foreach(['large', 'medium', 'small', 'small_square', 'xsmall_square'] as $preset) {
            
            $filepath = config("imagepresets.presets.$preset.path") . $filename;
            $this->assertTrue(file_exists($filepath));
            unlink($filepath);

        }

    }

    public function getImageFilenameByTitle($title) {

        return Content::whereType('photo')->whereTitle($title)->first()->images[0]->filename;
        
    }

}