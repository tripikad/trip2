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

/*
    public function setUp()
    {

        parent::setUp();
        
        $this->user1 = factory(App\User::class)->create(['verified' => true]);
        $this->user2 = factory(App\User::class)->create(['verified' => true]);
        
        $this->content = factory(Content::class)->create([
            'user_id' => $this->user1->id,
            'title' => 'Hello'
        ]);

        $this->follow = factory(Follow::class)->create([
            'user_id' => $this->user2->id,
            'followable_id' => $this->content->id
        ]);

    }
*/

    public function test_unlogged_user_can_not_access_follows()
    {

        $user1 = factory(App\User::class)->create(['verified' => true]);
        
        $this->visit("user/$user1->id")
            ->dontSee(trans('user.show.menu.follow'));

        $response = $this->call('GET', "user/$user1->id/follows");
        $this->assertEquals(401, $response->status());

    }

    public function test_user_can_not_access_other_user_follows()
    {

        $user1 = factory(App\User::class)->create(['verified' => true]);
        $user2 = factory(App\User::class)->create(['verified' => true]);

        $this->actingAs($user2)
            ->visit("user/$user1->id")
            ->dontSee(trans('user.show.menu.follow'));

        $response = $this->call('GET', "user/$user1->id/follows");
        $this->assertEquals(401, $response->status());

    }

    public function test_registered_user_can_follow_content()
    {

        $user1 = factory(App\User::class)->create(['verified' => true]);
        $user2 = factory(App\User::class)->create(['verified' => true]);
        
        $content = factory(Content::class)->create([
            'user_id' => $user1->id,
            'title' => 'Hello'
        ]);

        // Follow a post

        $this->actingAs($user2)
            ->visit("content/$content->type/$content->id")
            ->press(trans('content.action.follow.1.title'))
            ->seePageIs("content/$content->type/$content->id")
            ->see(trans('content.action.follow.1.info', ['title' => $content->title]))
            ->see(trans('content.action.follow.0.title'));

        // See followed post

        $this->actingAs($user2)
            ->visit("user/$user2->id")
            ->click(trans('menu.user.follow'))
            ->seePageIs("user/$user2->id/follows")
            ->click('Hello')
            ->seePageIs("content/$content->type/$content->id");

    }

}