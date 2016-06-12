<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Content;
use Carbon\Carbon;

class TravelmateTest extends TestCase
{
    use DatabaseTransactions;

    public function test_regular_user_cannot_edit_other_user_content()
    {
        $creator_user = factory(App\User::class)->create();
        $visitor_user = factory(App\User::class)->create();
        $datetime = Carbon::now()->addMonth(1)->toDateTimeString();
        $year = Carbon::parse($datetime)->year;
        $month = Carbon::parse($datetime)->month;
        $day = Carbon::parse($datetime)->day;

        // creator create content
        $this->actingAs($creator_user)
            ->visit('content/travelmate')
            ->click(trans('content.travelmate.create.title'))
            ->seePageIs('content/travelmate/create')
            ->type('Creator title travelmate', 'title')
            ->select($year, 'start_at_year')
            ->select($month, 'start_at_month')
            ->select($day, 'start_at_day')
            ->press(trans('content.create.submit.title'))
            ->see(trans('content.store.status.'.config('content_travelmate.store.status', 1).'.info', [
                'title' => 'Creator title travelmate',
            ]))
            ->see('Creator title travelmate')
            ->seeInDatabase('contents', [
                'user_id' => $creator_user->id,
                'title' => 'Creator title travelmate',
                'start_at' => $year.'-'.$month.'-'.$year.' 00:00:00',
                'type' => 'travelmate',
                'status' => 1,
            ]);

        // visitor view content
        $content_id = $this->getContentIdByTitleType('Creator title travelmate');
        $this->actingAs($visitor_user);
        $response = $this->call('GET', "content/travelmate/$content_id/edit");
        $this->visit("content/travelmate/$content_id")
            ->dontSeeInElement('form', trans('content.action.edit.title'))
            ->assertEquals(401, $response->status());
    }

    public function test_regular_user_can_create_content()
    {
        $regular_user = factory(App\User::class)->create();
        $datetime = Carbon::now()->addMonth(1)->toDateTimeString();
        $year = Carbon::parse($datetime)->year;
        $month = Carbon::parse($datetime)->month;
        $day = Carbon::parse($datetime)->day;

        $this->actingAs($regular_user)
            ->visit('content/travelmate')
            ->click(trans('content.travelmate.create.title'))
            ->seePageIs('content/travelmate/create')
            ->type('Hello title', 'title')
            ->select($year, 'start_at_year')
            ->select($month, 'start_at_month')
            ->select($day, 'start_at_day')
            ->press(trans('content.create.submit.title'))
            ->see(trans('content.store.status.1.info', [
                'title' => 'Hello title',
            ]))
            ->see('Hello title')
            ->see(str_limit($regular_user->name, 24))
            ->seeInDatabase('contents', [
                'user_id' => $regular_user->id,
                'title' => 'Hello title',
                'start_at' => $year.'-'.$month.'-'.$year.' 00:00:00',
                'type' => 'travelmate',
                'status' => 1,
            ]);

        $content = Content::whereTitle('Hello title')->first();

        $new_datetime = Carbon::now()->addMonth(2)->toDateTimeString();
        $year = Carbon::parse($new_datetime)->year;
        $month = Carbon::parse($new_datetime)->month;
        $day = Carbon::parse($new_datetime)->day;

        $this->actingAs($regular_user)
                ->visit("content/travelmate/$content->id")
                ->press(trans('content.action.edit.title'))
                ->seePageIs("content/travelmate/$content->id/edit")
                ->type('Hola titulo', 'title')
                ->select($year, 'start_at_year')
                ->select($month, 'start_at_month')
                ->select($day, 'start_at_day')
                ->press(trans('content.edit.submit.title'))
                ->seePageIs("content/travelmate/$content->id")
                ->see('Hola titulo')
                ->seeInDatabase('contents', [
                    'user_id' => $regular_user->id,
                    'title' => 'Hola titulo',
                    'start_at' => $year.'-'.$month.'-'.$year.' 00:00:00',
                    'type' => 'travelmate',
                    'status' => 1,
                ]);
    }

    public function test_admin_user_can_edit_content()
    {
        $creator_user = factory(App\User::class)->create();
        $editor_user = factory(App\User::class)->create([
            'role' => 'admin',
            'verified' => 1,
        ]);

        $datetime = Carbon::now()->addMonth(1)->toDateTimeString();
        $year = Carbon::parse($datetime)->year;
        $month = Carbon::parse($datetime)->month;
        $day = Carbon::parse($datetime)->day;

        // creator create content
        $this->actingAs($creator_user)
            ->visit('content/travelmate')
            ->click(trans('content.travelmate.create.title'))
            ->seePageIs('content/travelmate/create')
            ->type('Creator title travelmate', 'title')
            ->type('Creator body travelmate', 'body')
            ->select($year, 'start_at_year')
            ->select($month, 'start_at_month')
            ->select($day, 'start_at_day')
            ->press(trans('content.create.submit.title'))
            ->see(trans('content.store.status.'.config('content_travelmate.store.status', 1).'.info', [
                'title' => 'Creator title travelmate',
            ]))
            ->see('Creator title travelmate')
            ->seeInDatabase('contents', [
                'user_id' => $creator_user->id,
                'start_at' => $year.'-'.$month.'-'.$year.' 00:00:00',
                'title' => 'Creator title travelmate',
                'body' => 'Creator body travelmate',
                'type' => 'travelmate',
                'status' => 1,
            ]);

        $datetime = Carbon::now()->addMonth(2)->toDateTimeString();
        $year = Carbon::parse($datetime)->year;
        $month = Carbon::parse($datetime)->month;
        $day = Carbon::parse($datetime)->day;

        // editor edit content
        $content_id = $this->getContentIdByTitleType('Creator title travelmate');
        $this->actingAs($editor_user)
            ->visit("content/travelmate/$content_id")
            ->seeInElement('form', trans('content.action.edit.title'))
            ->press(trans('content.action.edit.title'))
            ->seePageIs("content/travelmate/$content_id/edit")
            ->type('Editor title travelmate', 'title')
            ->type('Editor body travelmate', 'body')
            ->select($year, 'start_at_year')
            ->select($month, 'start_at_month')
            ->select($day, 'start_at_day')
            ->press(trans('content.edit.submit.title'))
            ->see(trans('content.update.info', [
                'title' => 'Editor title travelmate',
            ]))
            ->seeInDatabase('contents', [
                'user_id' => $creator_user->id,
                'start_at' => $year.'-'.$month.'-'.$year.' 00:00:00',
                'title' => 'Editor title travelmate',
                'body' => 'Editor body travelmate',
                'type' => 'travelmate',
                'status' => 1,
            ]);
    }

    private function getContentIdByTitleType($title)
    {
        return Content::whereTitle($title)->first()->id;
    }
}
