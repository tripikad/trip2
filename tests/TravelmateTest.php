<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Content;

use Carbon\Carbon;

class TravelmateTest extends TestCase
{
    use DatabaseTransactions;

    public function test_regular_user_can_create_content()
    {

        $regular_user = factory(App\User::class)->create();
        $datetime = Carbon::now()->toDateTimeString();

        $this->actingAs($regular_user)
            ->visit("content/travelmate")
            ->click(trans("content.travelmate.create.title"))
            ->seePageIs("content/travelmate/create")
            ->type("Hello travelmate title", 'title')
            ->type($datetime, 'start_at')
            ->press(trans('content.create.submit.title'))
            ->see(trans('content.store.status.1.info', [
                'title' => "Hello travelmate title"
            ]))
            ->see("Hello travelmate title")
            ->see($regular_user->name)
            ->seeInDatabase('contents', [
                'user_id' => $regular_user->id,
                'title' => 'Hello travelmate title',
                'type' => 'travelmate',
                'start_at' => $datetime,
                'status' => 1
            ]);

    }

}