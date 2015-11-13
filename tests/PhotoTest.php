<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Content;

class PhotoTest extends TestCase
{
    use DatabaseTransactions;

    public function test_regular_user_can_post_and_edit_photos()
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

        $file = $this->getImageByTitle('Hello photo title');
        $content = $file->content()->first();
        $filename = $file->filename;
        $file_id = $file->id;

        // Check original file exists

        $filepath = config('imagepresets.original.path').$filename;
        $this->assertTrue(file_exists($filepath));     

        // See thumbnails exist

        foreach (['large', 'medium', 'small', 'small_square', 'xsmall_square'] as $preset) {
            $filepath = config("imagepresets.presets.$preset.path").$filename;
            $this->assertTrue(file_exists($filepath));
        }
   
        $this->see(trans('content.edit.title'))
            ->press(trans('content.edit.title'))
            ->seePageIs('content/photo/'.$content->id.'/edit')
            ->see('Hello photo title')
            ->type('New Hello photo title', 'title')
            ->attach(storage_path().'/tests/test2.jpeg', 'file')
            ->press(trans('content.edit.submit.title'))
            ->seePageIs('content/photo/'.$content->id)
            ->see(trans('content.update.info', ['title' => 'New Hello photo title']))
            ->see('New Hello photo title')
            ->seeInDatabase('contents', [
                'user_id' => $regular_user->id,
                'title' => 'New Hello photo title',
                'type' => 'photo',
                'status' => 1,
            ]);

            $file_new = $this->getImageByTitle('New Hello photo title');
            $filename_new = $file_new->filename;

            $filepath = config('imagepresets.original.path').$filename_new;
            $this->assertTrue(file_exists($filepath));      

            foreach (['large', 'medium', 'small', 'small_square', 'xsmall_square'] as $preset) {
                $filepath = config("imagepresets.presets.$preset.path").$filename_new;
                $this->assertTrue(file_exists($filepath));
            }

            //check if old images are unlinked
            $filepath = config('imagepresets.original.path').$filename;
            $this->assertFalse(file_exists($filepath));

            foreach (['large', 'medium', 'small', 'small_square', 'xsmall_square'] as $preset) {
                $filepath = config("imagepresets.presets.$preset.path").$filename;
                $this->assertFalse(file_exists($filepath));
            }

            //unlink new images
            unlink(config('imagepresets.original.path').$filename_new);

            foreach (['large', 'medium', 'small', 'small_square', 'xsmall_square'] as $preset) {
                $filepath = config("imagepresets.presets.$preset.path").$filename_new;
                unlink($filepath);
            }

    }

    public function getImageByTitle($title)
    {
        return Content::whereType('photo')->whereTitle($title)->first()->images[0];
    }
}
