<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Content;
use App\Comment;
use Carbon\Carbon;

class ContentUpdateTest extends TestCase
{
    use DatabaseTransactions;

    public function test_forum_content_do_not_update_timestamp_on_update()
    {
        $superuser = factory(App\User::class)->create(['role' => 'superuser']);

        $typesUpdatingTimestamp = [
            'news',
            'flight'
        ];
        $typesNotUpdatingTimestamp = [
            'forum',
            'buysell',
            'expat'
        ];
        
        // Mapping the correct PHPUnit assertions to each type
        $types = collect($typesUpdatingTimestamp)
            ->map(function($type) {
                return [$type => 'assertGreaterThan'];
            })
            ->merge(collect($typesNotUpdatingTimestamp)
                ->map(function($type) {
                    return [$type => 'assertEquals'];
                })
            )
            ->flatten(1);
        // Iterating over the types and making sure
        // the timestamps either update or not
        $types->each(function($assertion, $type) use ($superuser) {

            $content = factory(Content::class)->create([
                'user_id' => $superuser->id,
                'type' => $type
            ]);

            $first_date = Content::find($content->id)->updated_at;

            sleep(1);

            $this->actingAs($superuser)
                ->visit("content/$type/$content->id/edit")
                ->type("Hola titulo", 'title')
                ->press(trans('content.edit.submit.title'));

            $second_date = Content::find($content->id)->updated_at;

            $this->$assertion($first_date->timestamp, $second_date->timestamp, "Type: $type");
            
        });
    }

    public function test_content_timestamp_does_not_update_when_its_comment_is_updated()
    {
        $superuser = factory(App\User::class)->create(['role' => 'superuser']);

        $ContentTypes = [
            'forum',
            'buysell',
            'expat',
            'news',
            'flight'
        ];
        
        // Iterating over the types and making sure
        // the timestamps either update or not
        foreach ($ContentTypes as $type) {

            $content = factory(Content::class)->create([
                'user_id' => $superuser->id,
                'type' => $type,
            ]);

            $comment = factory(Comment::class)->create([
                'user_id' => $superuser->id,
                'content_id' => $content->id,
            ]);

            $first_date = Content::find($content->id)->updated_at;

            sleep(1);

            $this->actingAs($superuser)
                ->visit("comment/$comment->id/edit")
                ->type('Hola', 'body')
                ->press(trans('comment.edit.submit.title'));

            $second_date = Content::find($content->id)->updated_at;

            $this->assertEquals($first_date->timestamp, $second_date->timestamp);
        }
    }
    
}