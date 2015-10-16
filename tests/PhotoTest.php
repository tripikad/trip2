<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Content;

class PhotoTest extends TestCase
{
    use DatabaseTransactions;

    public function test_regular_user_can_post_photos()
    {
        $regular_user = factory(App\User::class)->create();

        $this->actingAs($regular_user)
            ->visit('content/photo')
            ->seeLink(trans('content.photo.create.title'))
            ->click(trans('content.photo.create.title'))
            ->seePageIs('content/photo/create')
            ->type('Hello photo title', 'title')
            ->attach(storage_path().'/tests/test.jpg', 'file')
            ->press(trans('content.create.submit.title'))
            ->seePageIs('content/photo')
            ->see(trans('content.store.status.1.info', ['title' => 'Hello photo title']))
            ->see('Hello photo title')
            ->seeInDatabase('contents', [
                'user_id' => $regular_user->id,
                'title' => 'Hello photo title',
                'type' => 'photo',
                'status' => 1,
            ]);

        $filename = $this->getImageFilenameByTitle('Hello photo title');

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

    public function getImageFilenameByTitle($title)
    {
        return Content::whereType('photo')->whereTitle($title)->first()->images[0]->filename;
    }
}
