<?php

namespace Tests\Browser;

use App\Content;
use App\Image;
use App\User;
use Tests\DuskTestCase;

class EditorTest extends DuskTestCase
{
    public function test_superuser_can_create_content_with_editor()
    {
        $super_user = factory(User::class)->create(['role' => 'superuser']);

        foreach (['news', 'flight'] as $type) {
            $this->browse(function ($browser) use ($super_user, $type) {
                $browser
                    ->loginAs($super_user)
                    ->visit("$type/create")
                    ->type('title', "Hola editores de titulo de $type")
                    ->click('textarea[readonly=readonly]') // @todo rework click target
                    ->pause(200) // Loading the editor
                    ->keys('.Editor__source textarea', "Hola editores de cuerpo de $type")
                    ->pause(1000) // Waiting for ajax-based preview
                    ->assertSeeIn('.Editor__target', "Hola editores de cuerpo de $type")
                    ->click('.Editor__toolPicker')
                    ->pause(200) // Loading the image picker
                    ->assertSeeIn('.ImagePicker', 'Lohista pilt siia')
                    ->attach('.dz-hidden-input', storage_path() . '/tests/test.jpg')
                    ->pause(1000) // Uploading image
                    ->click('.ImagePicker__card .ImagePicker__image');

                $image = Image::latest()->first();

                $browser
                    ->assertSeeIn('.Editor__source', $image->id)
                    ->click('.Editor__toolOk')
                    ->press('Lisa')
                    ->assertSee("Hola editores de titulo de $type");
            });

            // Cleanup

            $image = Image::latest()->first();

            $filepath = config('imagepresets.original.path') . $image->filename;

            $this->assertTrue(file_exists($filepath));
            unlink($filepath);

            foreach (['large', 'medium', 'small', 'small_square', 'xsmall_square'] as $preset) {
                $filepath = config("imagepresets.presets.$preset.path") . $image->filename;
                $this->assertTrue(file_exists($filepath));
                unlink($filepath);
            }

            $content = Content::whereTitle("Hola editores de titulo de $type")
                ->whereType($type)
                ->whereUserId($super_user->id)
                ->first()
                ->delete();
        }

        $super_user->delete();
    }
}
