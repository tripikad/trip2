<?php

use App\Content;
use Illuminate\Foundation\Testing\DatabaseTransactions;

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
            //'internal',
            //'static',
            'flight',
            //'news',
        ];
    }

    public function test_regular_user_can_create_and_edit_public_content()
    {
        $regular_user = factory(App\User::class)->create();

        foreach ($this->publicContentTypes as $type) {
            $this->actingAs($regular_user)
                ->visit("content/$type")
                ->click(trans("content.$type.create.title"))
                //->seePageIs("$type/create") // TODO: forum support
                ->type("Hello title $type", 'title')
                ->type("Hello body $type", 'body')
                ->press(trans('content.create.submit.title'))
                ->see("Hello title $type")
                ->seeInDatabase('contents', [
                    'user_id' => $regular_user->id,
                    'title' => "Hello title $type",
                    'body' => "Hello body $type",
                    // 'type' => $type, // TODO: forum support
                    'status' => 1,
                ]);

            $content = Content::whereTitle("Hello title $type")->first();

            $this->actingAs($regular_user)
                    ->visit("content/$type/$content->id")
                    ->click(trans('content.action.edit.title'))
                    // ->seePageIs("$type/$content->id/edit")
                    ->type("Hola titulo $type", 'title')
                    ->type("Hola cuerpo $type", 'body')
                    ->press(trans('content.edit.submit.title'))
                    ->seePageIs(config('sluggable.contentTypeMapping')[$content->type].'/'.$content->slug)
                    ->see("Hola titulo $type")
                    ->seeInDatabase('contents', [
                        'user_id' => $regular_user->id,
                        'title' => "Hola titulo $type",
                        'body' => "Hola cuerpo $type",
                        // 'type' => $type,
                        'status' => 1,
                    ]);
        }
    }

    /**
     * @expectedException PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Received status code [404]
     */
    public function test_regular_user_can_not_create_private_content()
    {
        $regular_user = factory(App\User::class)->create();

        foreach ($this->privateContentTypes as $type) {

            // Acting as unlogged user
            $this->visit("content/$type")
                ->dontSee(trans("content.$type.create.title"))
                ->visit("content/$type/create"); // 404

            // Acting as registered user
            $this->actingAs($regular_user)
                ->visit("content/$type")
                ->dontSee(trans("content.$type.create.title"))
                ->visit("content/$type/create"); // 404
        }
    }

    public function test_regular_user_cannot_create_admin_only_content()
    {
        $creator_user = factory(App\User::class)->create([
            'role' => 'admin',
            'verified' => 1,
        ]);
        $regular_user = factory(App\User::class)->create();

        foreach ($this->privateContentTypes as $type) {

            // Regular user try to create content

            $this->actingAs($regular_user);
            $response = $this->call('GET', "$type/create");
            $this->assertEquals(401, $response->status());

            // Admin user can create content

            $this->actingAs($creator_user)
                ->visit("$type/create")
                ->type("Admin title $type", 'title')
                ->type("Admin body $type", 'body');

            if ($type == 'flight') {
                $this->type('200', 'price');
                $seeInDatabase = [
                    'user_id' => $creator_user->id,
                    'title' => "Admin title $type",
                    'body' => "Admin body $type",
                    'type' => $type,
                    'price' => 200,
                ];
            } else {
                $seeInDatabase = [
                    'user_id' => $creator_user->id,
                    'title' => "Admin title $type",
                    'body' => "Admin body $type",
                    'type' => $type,
                ];
            }

            $this->press(trans('content.create.submit.title'))
                ->seeInDatabase('contents', $seeInDatabase);
        }
    }

    public function test_regular_user_cannot_edit_other_user_content()
    {
        $creator_user = factory(App\User::class)->create([
            'role' => 'admin',
            'verified' => 1,
        ]);
        $visitor_user = factory(App\User::class)->create();

        foreach ($this->privateContentTypes as $type) {

            // creator create content
            $this->actingAs($creator_user)
                ->visit("content/$type")
                ->click(trans("content.$type.create.title"))
                ->seePageIs("$type/create")
                ->type("Creator title $type", 'title')
                ->type("Creator body $type", 'body')
                ->press(trans('content.create.submit.title'))
                //->see("Creator title $type")
                ->seeInDatabase('contents', [
                    'user_id' => $creator_user->id,
                    'title' => "Creator title $type",
                    'body' => "Creator body $type",
                    'type' => $type,
                ]);

            // visitor view content
            $content_id = $this->getContentIdByTitleType("Creator title $type");
            $this->actingAs($visitor_user);
            $response = $this->call('GET', "$type/$content_id/edit");
            $this->visit("content/$type/$content_id")
                ->dontSeeInElement('form', trans('content.action.edit.title'))
                ->assertEquals(401, $response->status());
        }
    }

    public function test_admin_user_can_edit_content()
    {
        $types = [
            'forum',
            'expat',
            'buysell',
        ];

        $creator_user = factory(App\User::class)->create();
        $editor_user = factory(App\User::class)->create([
            'role' => 'admin',
            'verified' => 1,
        ]);

        foreach ($types as $type) {

            // creator create content
            $this->actingAs($creator_user)
                ->visit("content/$type")
                ->click(trans("content.$type.create.title"))
                //->seePageIs("$type/create")
                ->type("Creator title $type", 'title')
                ->type("Creator body $type", 'body')
                ->press(trans('content.create.submit.title'))
                ->see("Creator title $type")
                ->seeInDatabase('contents', [
                    'user_id' => $creator_user->id,
                    'title' => "Creator title $type",
                    'body' => "Creator body $type",
                    //'type' => $type,
                ]);

            // editor edit content
            $content_id = $this->getContentIdByTitleType("Creator title $type");
            $this->actingAs($editor_user)
                ->visit("content/$type/$content_id")
                ->click(trans('content.action.edit.title'))
                //->seePageIs("$type/$content_id/edit")
                ->type("Editor title $type", 'title')
                ->type("Editor body $type", 'body')
                ->press(trans('content.edit.submit.title'))
                ->seeInDatabase('contents', [
                    'user_id' => $creator_user->id,
                    'title' => "Editor title $type",
                    'body' => "Editor body $type",
                    //'type' => $type,
                ]);
        }
    }

    private function getContentIdByTitleType($title)
    {
        return Content::whereTitle($title)->first()->id;
    }
}
