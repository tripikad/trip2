<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Content;
use App\Follow;

class FollowTest extends TestCase
{

    use DatabaseTransactions;

    public function test_user_can_follow_content()
    {
        
        $user1 = factory(App\User::class)->create(['verified' => true]);
        $user2 = factory(App\User::class)->create(['verified' => true]);
        
        $content = factory(Content::class)->create([
            'user_id' => $user1->id,
            'title' => 'Hello'
        ]);

        $follow = factory(Follow::class)->create([
            'user_id' => $user2->id,
            'followable_id' => $content->id
        ]);

        $this->actingAs($user2)
            ->visit("user/$user2->id")
            ->seeLink(trans('user.show.menu.follow'))
            ->click(trans('user.show.menu.follow'))
            ->see('Hello')
            ->click('Hello')
            ->seePageIs("content/$content->type/$content->id");

    }

}