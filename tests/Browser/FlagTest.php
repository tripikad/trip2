<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

use App\User;
use App\Content;
use App\Flag;

class FlagTest extends DuskTestCase
{
    public function test_regular_user_can_flag_forum_content()
    {
        $regular_user = factory(User::class)->create();

        $content = factory(Content::class)->create([
            'user_id' => factory(User::class)->create()->id,
            'type' => 'forum'
        ]);

        $this->browse(function ($browser) use ($regular_user, $content) {
            $browser
                ->loginAs($regular_user)
                ->visit("node/$content->id") // @todo Use non-legacy ID-based alias
                ->assertSeeIn('.Flag--green .Flag__value', '0')
                ->click('.Flag--green .Flag__icon')
                ->pause(200)
                ->assertSeeIn('.Flag--green .Flag__value', '1')
                ->assertSeeIn('.Alert', 'Märkisid postituse meeldivaks')
                ->click('.Flag--green .Flag__icon')
                ->pause(200)
                ->assertSeeIn('.Flag--green .Flag__value', '0')
                ->assertSeeIn('.Alert', 'Mõtlesid ringi');
        });

        $content->delete();
        $regular_user->delete();
    }
}
