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
        $year = Carbon::parse($datetime)->year;
        $month = Carbon::parse($datetime)->month;
        $day = Carbon::parse($datetime)->day;
        $hour = Carbon::parse($datetime)->hour;
        $minute = Carbon::parse($datetime)->minute;
        $second = Carbon::parse($datetime)->second;

        $this->actingAs($regular_user)
            ->visit('content/travelmate')
            ->click(trans('content.travelmate.create.title'))
            ->seePageIs('content/travelmate/create')
            ->type('Hello title', 'title')
            ->select($year, 'start_at_year')
            ->select($month, 'start_at_month')
            ->select($day, 'start_at_day')
            ->select($hour, 'start_at_hour')
            ->select($minute, 'start_at_minute')
            ->select($second, 'start_at_second')
            ->press(trans('content.create.submit.title'))
            ->see(trans('content.store.status.1.info', [
                'title' => 'Hello title',
            ]))
            ->see('Hello title')
            //->see(str_limit($regular_user->name, 24))
            ->seeInDatabase('contents', [
                'user_id' => $regular_user->id,
                'title' => 'Hello title',
                'start_at' => $datetime,
                'type' => 'travelmate',
                'status' => 1,
            ]);

        $content = Content::whereTitle('Hello title')->first();

        $new_datetime = Carbon::now()->addMonth(2)->toDateTimeString();
        $year = Carbon::parse($new_datetime)->year;
        $month = Carbon::parse($new_datetime)->month;
        $day = Carbon::parse($new_datetime)->day;
        $hour = Carbon::parse($new_datetime)->hour;
        $minute = Carbon::parse($new_datetime)->minute;
        $second = Carbon::parse($new_datetime)->second;

        $this->actingAs($regular_user)
                ->visit("content/travelmate/$content->id")
                ->press(trans('content.action.edit.title'))
                ->seePageIs("content/travelmate/$content->id/edit")
                ->type('Hola titulo', 'title')
                ->select($year, 'start_at_year')
                ->select($month, 'start_at_month')
                ->select($day, 'start_at_day')
                ->select($hour, 'start_at_hour')
                ->select($minute, 'start_at_minute')
                ->select($second, 'start_at_second')
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
