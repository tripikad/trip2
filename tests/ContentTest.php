<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Content;

class ContentTest extends TestCase
{
    use DatabaseTransactions;

    protected $publicContentTypes;

    public function setUp()
    {
        parent::setUp();

        $this->publicContentTypes = [
            'blog',
            'forum',
            'expat',
            'buysell',
        ];

        $this->privateContentTypes = [
//          'internal',
//          'static',
            'flight',
            'news',
            'shortnews',
        ];
    }

    public function test_regular_user_can_create_and_edit_public_content()
    {
        $this->markTestSkipped();

        $regular_user = factory(App\User::class)->create();

        foreach ($this->publicContentTypes as $type) {
            $this->actingAs($regular_user)
                ->visit("content/$type")
                ->click(trans("content.$type.create.title"))
                ->seePageIs("content/$type/create")
                ->type("Hello title $type", 'title')
                ->type("Hello body $type", 'body')
                ->press(trans('content.create.submit.title'))
                ->see(trans('content.store.status.1.info', [
                    'title' => "Hello title $type",
                ]))
                ->see("Hello title $type")
                ->see($regular_user->name)
                ->seeInDatabase('contents', [
                    'user_id' => $regular_user->id,
                    'title' => "Hello title $type",
                    'body' => "Hello body $type",
                    'type' => $type,
                    'status' => 1,
                ]);

            $content = Content::whereTitle("Hello title $type")->first();

            $this->actingAs($regular_user)
                    ->visit("content/$type/$content->id")
                    ->press(trans('content.action.edit.title'))
                    ->seePageIs("content/$type/$content->id/edit")
                    ->type("Hola titulo $type", 'title')
                    ->type("Hola cuerpo $type", 'body')
                    ->press(trans('content.edit.submit.title'))
                    ->seePageIs("content/$type/$content->id")
                    ->see("Hola titulo $type")
                    ->seeInDatabase('contents', [
                        'user_id' => $regular_user->id,
                        'title' => "Hola titulo $type",
                        'body' => "Hola cuerpo $type",
                        'type' => $type,
                        'status' => 1,
                    ]);
        }
    }

/*
    public function test_regular_user_can_not_create_private_content()
    {
        $regular_user = factory(App\User::class)->create();

        foreach ($this->privateContentTypes as $type) {

            // Acting as unlogged user

            $this->visit("content/$type")
                ->dontSee(trans("content.$type.create.title"))
                ->visit("content/$type/create"); // 401

            // Acting as registered user

            $this->actingAs($regular_user)
                ->visit("content/$type")
                ->dontSee(trans("content.$type.create.title"))
                ->visit("content/$type/create"); // 401

        }

    }
*/
}
