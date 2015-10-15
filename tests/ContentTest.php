<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Content;

class ContentTest extends TestCase
{
    use DatabaseTransactions;

    protected $publicContentTypes;

    public function setUp() {

        parent::setUp();

        $this->publicContentTypes = [
            'blog',
            'forum',
            'expat',
            'buysell',
        //  'travelmate',
        //  'photo'
        ];

        $this->privateContentTypes = [
            'internal',
            'static',
            'flight',
            'news',
            'shortnews',
        ];

    }

    public function test_regular_user_can_create_content()
    {

        $regular_user = factory(App\User::class)->create();

        foreach($this->publicContentTypes as $type) {

            $this->actingAs($regular_user)
                ->visit("content/$type")
                ->click(trans("content.$type.create.title"))
                ->seePageIs("content/$type/create")
                ->type("Hello title $type", 'title')
                ->type("Hello body $type", 'body')
                ->press(trans('content.create.submit.title'))
                ->see(trans('content.store.status.1.info', [
                    'title' => "Hello title $type"
                ]))
                ->see("Hello title $type")
                ->see($regular_user->name)
                ->seeInDatabase('contents', [
                    'user_id' => $regular_user->id,
                    'title' => "Hello title $type",
                    'body' => "Hello body $type",
                    'type' => $type,
                    'status' => 1
                ]);

        }

    }

}