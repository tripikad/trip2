<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Content;

class ActivityTest extends TestCase
{

    use DatabaseTransactions;

    public function test_unlogged_user_can_see_user_activity()
    {

        $user1 = factory(App\User::class)->create(['verified' => true]);
        
        $content1 = factory(Content::class)->create([
            'user_id' => $user1->id,
            'title' => 'Hello'
        ]);

        $this->visit("user/$user1->id")
            ->see($user1->name)
            ->seeLink($content1->title);

    }

}