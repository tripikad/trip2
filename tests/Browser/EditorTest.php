<?php

namespace Tests\Browser;

use App\User;
use App\Content;
use Tests\DuskTestCase;

class EditorTest extends DuskTestCase
{
    public function test_superuser_can_create_content_with_editor()
    {
        $super_user = factory(User::class)->create(['role' => 'superuser']);

        foreach (['flight', 'news'] as $type) {
            $this->browse(function ($browser) use ($super_user, $type) {
                $browser
                ->loginAs($super_user)
                ->visit("$type/create")
                ->type('title', "Hola editores de titulo de $type")
                ->click('textarea[readonly=readonly]') // @todo rework click target
                ->pause(500) // Loading the editor
                ->keys('.Editor__source textarea', "Hola editores de cuerpo de $type")
                ->pause(2000) // Waiting for ajax-based preview
                ->assertSeeIn('.Editor__target', "Hola editores de cuerpo de $type")
                ->click('.Editor__toolbarRight > .Editor__tool') // @todo rework click target
                ->press('Lisa')
                ->assertSee("Hola editores de titulo de $type");
            });

            // Cleanup

            $content = Content::whereTitle("Hola editores de titulo de $type")
                ->whereBody("Hola editores de cuerpo de $type")
                ->whereType($type)
                ->whereUserId($super_user->id)
                ->first()
                ->delete();
        }

        $super_user->delete();
    }
}
