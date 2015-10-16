<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Content;
use Carbon\Carbon;

class TravelmateTest extends TestCase
{
    use DatabaseTransactions;

    public function test_regular_user_can_create_content()
    {
        $regular_user = factory(App\User::class)->create();
        $datetime = Carbon::now()->addMonth(1)->toDateTimeString();

        $this->actingAs($regular_user)
            ->visit('content/travelmate')
            ->click(trans('content.travelmate.create.title'))
            ->seePageIs('content/travelmate/create')
            ->type('Hello title', 'title')
            ->type($datetime, 'start_at')
            ->press(trans('content.create.submit.title'))
            ->see(trans('content.store.status.1.info', [
                'title' => 'Hello title',
            ]))
            ->see('Hello title')
            ->see($regular_user->name)
            ->seeInDatabase('contents', [
                'user_id' => $regular_user->id,
                'title' => 'Hello title',
                'start_at' => $datetime,
                'type' => 'travelmate',
                'status' => 1,
            ]);

        $content = Content::whereTitle('Hello title')->first();

        $new_datetime = Carbon::now()->addMonth(2)->toDateTimeString();

        $this->actingAs($regular_user)
                ->visit("content/travelmate/$content->id")
                ->press(trans('content.action.edit.title'))
                ->seePageIs("content/travelmate/$content->id/edit")
                ->type('Hola titulo', 'title')
                ->type($new_datetime, 'start_at')
                ->press(trans('content.edit.submit.title'))
                ->seePageIs("content/travelmate/$content->id")
                ->see('Hola titulo')
                ->seeInDatabase('contents', [
                    'user_id' => $regular_user->id,
                    'title' => 'Hola titulo',
                    'start_at' => $new_datetime,
                    'type' => 'travelmate',
                    'status' => 1,
                ]);
    }
}
