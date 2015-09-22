<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Content;

class AdminTest extends TestCase
{
    use DatabaseTransactions;

    public function test_unlogged_or_regular_user_can_not_see_images()
    {

        // Unlogged user

        $response = $this->call('GET', 'admin/image');
        $this->assertEquals(401, $response->status());

        // Regular user

        $user1 = factory(App\User::class)->create([
                'verified' => 'true',
                'role' => 'regular'
        ]);

        $response = $this->actingAs($user1)
            ->call('GET', 'admin/image');
        $this->assertEquals(401, $response->status());

    }

    public function test_admin_user_can_see_images()
    {

        $user1 = factory(App\User::class)->create([
                'verified' => 'true',
                'role' => 'admin'
        ]);

        $this->actingAs($user1)
            ->visit('user/' . $user1->id)
            ->seeLink(trans('menu.header.admin'))
            ->click(trans('menu.header.admin'))
            ->seeLink(trans('menu.admin.image'))
            ->click(trans('menu.admin.image'))
            ->seePageIs('admin/image')
            ->see(trans('admin.image.index.title'));

    }

    public function test_unlogged_or_regular_user_can_not_see_unpublished_content()
    {

        // Unlogged user

        $response = $this->call('GET', 'admin/content');
        $this->assertEquals(401, $response->status());

        // Regular user

        $user1 = factory(App\User::class)->create([
                'verified' => 'true',
                'role' => 'regular'
        ]);

        $response = $this->actingAs($user1)
            ->call('GET', 'admin/content');
        $this->assertEquals(401, $response->status());

    }
    

    public function test_admin_user_can_see_unpublished_content()
    {

        $user1 = factory(App\User::class)->create([
            'verified' => 'true',
            'role' => 'admin'
        ]);

        $user2 = factory(App\User::class)->create([
            'verified' => 'true',
            'role' => 'admin'
        ]);

        $content1 = factory(App\Content::class)->create([
            'user_id' => $user2->id,
            'title' => 'Hello unpublished',
            'type' => 'forum',
            'status' => 0,
        ]);

        $this->actingAs($user1)
            ->visit('user/' . $user1->id)
            ->seeLink(trans('menu.header.admin'))
            ->click(trans('menu.header.admin'))
            ->seeLink(trans('menu.admin.content'))
            ->click(trans('menu.admin.content'))
            ->seePageIs('admin/content')
            ->see(trans('admin.content.index.title'))
            ->seeLink('Hello unpublished')
            ->click('Hello unpublished')
            ->seePageIs('content/' . $content1->type . '/'. $content1->id)
            ->see('Hello unpublished');

    }

    public function test_unlogged_or_regular_user_can_not_see_internal_forum()
    {

        // Unlogged user

        $response = $this->call('GET', 'content/internal');
        $this->assertEquals(401, $response->status());

        // Regular user

        $user1 = factory(App\User::class)->create([
                'verified' => 'true',
                'role' => 'regular'
        ]);

        $response = $this->actingAs($user1)
            ->call('GET', 'content/internal');
        $this->assertEquals(401, $response->status());

    }

    public function test_admin_user_can_see_internal_forum()
    {

        $user1 = factory(App\User::class)->create([
                'verified' => 'true',
                'role' => 'admin'
        ]);

        $user2 = factory(App\User::class)->create([
            'verified' => 'true',
            'role' => 'admin'
        ]);

        $content1 = factory(App\Content::class)->create([
            'user_id' => $user2->id,
            'title' => 'Hello internal',
            'type' => 'internal',
        ]);

        $this->actingAs($user1)
            ->visit('user/' . $user1->id)
            ->seeLink(trans('menu.header.admin'))
            ->click(trans('menu.header.admin'))
            ->seePageIs('content/internal')
            ->see(trans('content.internal.index.title'))
            ->seeLink('Hello internal')
            ->click('Hello internal')
            ->seePageIs('content/' . $content1->type . '/'. $content1->id)
            ->see('Hello internal');

    }

}