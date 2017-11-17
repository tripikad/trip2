<?php

namespace Tests\Feature;

use App\User;
use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StatisticsTest extends BrowserKitTestCase
{
    use DatabaseTransactions;

    public function test_unlogged_or_regular_or_admin_can_not_see_statistics()
    {

        // Unlogged user

        $response = $this->call('GET', 'statistics');
        $this->assertEquals(401, $response->status());

        // Regular user

        $regular_user = factory(User::class)->create([
            'verified' => 'true',
            'role' => 'regular',
        ]);

        $response = $this->actingAs($regular_user)
            ->call('GET', 'statistics');
        $this->assertEquals(401, $response->status());

        // Admin user

        $admin_user = factory(User::class)->create([
            'verified' => 'true',
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin_user)
            ->call('GET', 'statistics');
        $this->assertEquals(401, $response->status());
    }

    public function test_superuser_can_see_statistics()
    {
        $super_user = factory(User::class)->create([
            'verified' => 'true',
            'role' => 'superuser',
        ]);

        $this->actingAs($super_user)
            ->visit('/statistics')
            ->see(trans('statistics.index.title'));
    }
}
