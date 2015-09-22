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

    protected $user1;
    protected $user2;

    protected $content;

    protected $follow;

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

    public function test_unlogged_user_can_not_access_follows()
    {

        $this->visit('user/' . $this->user2->id)
            ->dontSee(trans('user.show.menu.follow'));

        $response = $this->call('GET', 'user/' . $this->user2->id . '/follows');
        $this->assertEquals(401, $response->status());

    }

    public function test_user_can_not_access_other_user_follows()
    {

        $this->actingAs($this->user1)
            ->visit('user/' . $this->user2->id)
            ->dontSee(trans('user.show.menu.follow'));

        $response = $this->call('GET', 'user/' . $this->user2->id . '/follows');
        $this->assertEquals(401, $response->status());

    }

    public function test_registered_user_can_follow_content()
    {

        $this->actingAs($this->user2)
            ->visit('user/' . $this->user2->id)
            ->seeLink(trans('menu.user.follow'))
            ->click(trans('menu.user.follow'))
            ->seePageIs('user/' . $this->user2->id . '/follows')
            ->see('Hello')
            ->click('Hello')
            ->seePageIs('content/' . $this->content->type . '/' . $this->content->id);

    }

}