<?php

namespace Tests\Feature;

use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Content;

class FollowTest extends BrowserKitTestCase
{
    use DatabaseTransactions;

    public function test_unlogged_user_can_not_access_follows()
    {
        $user1 = factory(User::class)->create(['verified' => true]);

        $this->visit("user/$user1->id")
            ->dontSee(trans('user.show.menu.follow'));

        // Return 401

        $response = $this->call('GET', "user/$user1->id/follows");

        $this->assertEquals(401, $response->status());
    }

    public function test_user_can_not_access_other_user_follows()
    {
        $user1 = factory(User::class)->create(['verified' => true]);
        $user2 = factory(User::class)->create(['verified' => true]);

        $this->actingAs($user2)
            ->visit("user/$user1->id")
            ->dontSee(trans('user.show.menu.follow'));

        // Return 401

        $response = $this->call('GET', "user/$user1->id/follows");

        $this->assertEquals(401, $response->status());
    }

    public function test_registered_user_can_follow_and_unfollow_content()
    {
        $user1 = factory(User::class)->create(['verified' => true]);
        $user2 = factory(User::class)->create(['verified' => true]);

        $content = factory(Content::class)->create([
            'user_id' => $user1->id,
            'title' => 'Buenos dias',
        ]);

        // Follow a post

        $this->actingAs($user2)
            ->visit(config('sluggable.contentTypeMapping')[$content->type].'/'.$content->slug)
            ->press(trans('content.action.follow.1.title'))
            ->seePageIs(config('sluggable.contentTypeMapping')[$content->type].'/'.$content->slug)
            ->seeInDatabase('follows', [
                'user_id' => $user2->id,
                'followable_id' => $content->id,
                'followable_type' => 'App\Content',
            ]);

        // See followed post

        $this->actingAs($user2)
            ->visit('/')
            ->click(trans('menu.user.follow'))
            ->seePageIs("user/$user2->id/follows")
            ->click('Buenos dias')
            ->seePageIs(config('sluggable.contentTypeMapping')[$content->type].'/'.$content->slug);

        // Unfollow post

        $this->actingAs($user2)
            ->visit(config('sluggable.contentTypeMapping')[$content->type].'/'.$content->slug)
            ->press(trans('content.action.follow.0.title'))
            ->seePageIs(config('sluggable.contentTypeMapping')[$content->type].'/'.$content->slug)
            ->missingFromDatabase('follows', [
                'user_id' => $user2->id,
                'followable_id' => $content->id,
                'followable_type' => 'App\Content',
            ]);

        // Do not see unfollowed post

        $this->actingAs($user2)
            ->visit("user/$user2->id/follows")
            ->dontSee('Buenos dias');
    }
}
