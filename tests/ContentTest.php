<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Content;

class ContentTest extends TestCase
{
    use DatabaseTransactions;

    protected $publicContentTypes;
    protected $privateContentTypes;

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

    /**
     * @expectedException PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Received status code [401]
     */
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

    public function test_regular_user_cannot_edit_other_user_content()
    {
        $creator_user = factory(App\User::class)->create();
        $visitor_user = factory(App\User::class)->create();

        foreach ($this->privateContentTypes as $type) {

            // creator create content
            $this->actingAs($creator_user)
                ->visit("content/$type")
                ->click(trans("content.$type.create.title"))
                ->seePageIs("content/$type/create")
                ->type("Creator title $type", 'title')
                ->type("Creator body $type", 'body')
                ->press(trans('content.create.submit.title'))
                ->see(trans('content.store.status.'.config("content_$type.store.status", 1).'.info', [
                    'title' => "Creator title $type",
                ]))
                ->see("Creator title $type")
                ->seeInDatabase('contents', [
                    'user_id' => $creator_user->id,
                    'title' => "Creator title $type",
                    'body' => "Creator body $type",
                    'type' => $type,
                    'status' => 1,
                ]);

            // visitor view content
            $content_id = $this->getContentIdByTitleType("Creator title $type");
            $this->actingAs($visitor_user);
            $response = $this->call('GET', "content/$type/$content_id/edit");
            $this->visit("content/$type/$content_id")
                ->dontSeeInElement('.c-actions__link', trans('content.action.edit.title'))
                ->assertEquals(401, $response->status());
        }
    }

    private function getContentIdByTitleType($title)
    {
        return Content::whereTitle($title)->first()->id;
    }
}
