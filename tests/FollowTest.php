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

    /**
     * @expectedException PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Received status code [401]
     */

    public function test_unlogged_user_can_not_access_follows()
    {

        $user1 = factory(App\User::class)->create(['verified' => true]);
        
        $this->visit("user/$user1->id")
            ->dontSee(trans('user.show.menu.follow'));

        $this->visit("user/$user1->id/follows");

    }

    /**
     * @expectedException PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Received status code [401]
     */

    public function test_user_can_not_access_other_user_follows()
    {

        $user1 = factory(App\User::class)->create(['verified' => true]);
        $user2 = factory(App\User::class)->create(['verified' => true]);

        $this->actingAs($user2)
            ->visit("user/$user1->id")
            ->dontSee(trans('user.show.menu.follow'));

        $this->visit("user/$user1->id/follows");

    }

    public function test_registered_user_can_follow_and_unfollow_content()
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
            ->seeInDatabase('follows', [
                'user_id' => $user2->id, 
                'followable_id' => $content->id,
                'followable_type' => 'App\Content'
            ]);

        // See followed post

        $this->actingAs($user2)
            ->visit("user/$user2->id")
            ->click(trans('menu.user.follow'))
            ->seePageIs("user/$user2->id/follows")
            ->click('Hello')
            ->seePageIs("content/$content->type/$content->id");

        // Unfollow post

        $this->actingAs($user2)
            ->visit("content/$content->type/$content->id")
            ->press(trans('content.action.follow.0.title'))
            ->seePageIs("content/$content->type/$content->id")
            ->see(trans('content.action.follow.0.info', ['title' => $content->title]))
            ->missingFromDatabase('follows', [
                'user_id' => $user2->id, 
                'followable_id' => $content->id,
                'followable_type' => 'App\Content'
            ]);

        // Do not see unfollowed post

        $this->actingAs($user2)
            ->visit("user/$user2->id/follows")
            ->dontSee('Hello');

    }

}