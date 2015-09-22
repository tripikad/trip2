<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Message;

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

        $user2 = factory(App\User::class)->create([
                'verified' => 'true',
                'role' => 'admin'
        ]);

        $this->actingAs($user2)
            ->visit('user/' . $user2->id)
            ->seeLink(trans('menu.header.admin'))
            ->click(trans('menu.header.admin'))
            ->seeLink(trans('menu.admin.image'))
            ->click(trans('menu.admin.image'))
            ->seePageIs('admin/image')
            ->see(trans('image.index.title'));

    }

}