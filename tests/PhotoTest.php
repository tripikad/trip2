<?php

use App\Content;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PhotoTest extends TestCase
{
    use DatabaseTransactions;

    public function test_regular_user_cannot_edit_other_user_photo()
    {
        $creator_user = factory(App\User::class)->create();
        $visitor_user = factory(App\User::class)->create();

        // creator create content
        $this->actingAs($creator_user)
            ->visit('reisipildid')
            ->click(trans('content.photo.create.title'))
            ->seePageIs('photo/create')
            ->type('Creator title photo', 'title')
            ->attach(storage_path().'/tests/test.jpg', 'file')
            ->press(trans('content.create.submit.title'))
            ->see('Creator title photo')
            ->seeInDatabase('contents', [
                'user_id' => $creator_user->id,
                'title' => 'Creator title photo',
                'type' => 'photo',
                'status' => 1,
            ]);

        // visitor view content
        /*
        $content_id = $this->getContentIdByTitleType('Creator title photo');
        $this->actingAs($visitor_user);
        $response = $this->call('GET', "photo/$content_id/edit");
        $this->visit("content/photo/$content_id")
            ->dontSeeInElement('form', trans('content.action.edit.title'))
            ->assertEquals(401, $response->status());
        */
    }

    public function test_admin_user_can_edit_photo()
    {
        $creator_user = factory(App\User::class)->create();
        $editor_user = factory(App\User::class)->create([
            'role' => 'admin',
            'verified' => 1,
        ]);

        // creator create content
        $this->actingAs($creator_user)
            ->visit('reisipildid')
            ->click(trans('content.photo.create.title'))
            ->seePageIs('photo/create')
            ->type('Creator title photo', 'title')
            ->attach(storage_path().'/tests/test.jpg', 'file')
            ->press(trans('content.create.submit.title'))
            ->see('Creator title photo')
            ->seeInDatabase('contents', [
                'user_id' => $creator_user->id,
                'title' => 'Creator title photo',
                'type' => 'photo',
                'status' => 1,
            ]);

        // editor edit content
        $content_id = $this->getContentIdByTitleType('Creator title photo');
        $this->actingAs($editor_user)
            /*->visit("photo/$content_id")
            ->seeInElement('form', trans('content.action.edit.title'))
            ->press(trans('content.action.edit.title'))
            */
            ->visit("photo/$content_id/edit")
            ->type('Editor title photo', 'title')
            ->attach(storage_path().'/tests/test2.jpeg', 'file')
            ->press(trans('content.edit.submit.title'))
            ->seeInDatabase('contents', [
                'user_id' => $creator_user->id,
                'title' => 'Editor title photo',
                'type' => 'photo',
                'status' => 1,
            ]);
    }

    public function test_regular_user_can_post_and_edit_photos()
    {
        $regular_user = factory(App\User::class)->create();

        $this->actingAs($regular_user)
            ->visit('reisipildid')
            ->seeLink(trans('content.photo.create.title'))
            ->click(trans('content.photo.create.title'))
            ->seePageIs('photo/create')
            ->type('Hello photo title', 'title')
            ->attach(storage_path().'/tests/test.jpg', 'file')
            ->press(trans('content.create.submit.title'))
            //->seePageIs(config('sluggable.contentTypeMapping')['photo'])
            //->see('Hello photo title')
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
            //->press(trans('content.edit.title'))
            ->visit('photo/'.$content->id.'/edit')
            ->see('Hello photo title')
            ->type('New Hello photo title', 'title')
            ->attach(storage_path().'/tests/test2.jpeg', 'file')
            ->press(trans('content.edit.submit.title'))
            //->seePageIs(config('sluggable.contentTypeMapping')[$content->type].'/'.$content->slug)
            //->see('New Hello photo title')
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

        // Check if old images are unlinked

        $filepath = config('imagepresets.original.path').$filename;
        $this->assertFalse(file_exists($filepath));

        foreach (['large', 'medium', 'small', 'small_square', 'xsmall_square'] as $preset) {
            $filepath = config("imagepresets.presets.$preset.path").$filename;
            $this->assertFalse(file_exists($filepath));
        }

        // Unlink new images

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

    private function getContentIdByTitleType($title)
    {
        return Content::whereTitle($title)->first()->id;
    }
}
