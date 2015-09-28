<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Content;

class CommentTest extends TestCase
{
    use DatabaseTransactions;

    public static $types = ['blog','forum','buysell','expat','travelmate','flight','news','photo'];
    public static $exclude_types = ['static','internal','shortnews'];


    public function setUp()
    {
        parent::setUp();
 
        $this->setTypes();
    }

    protected function setTypes()
    {
        $types_tmp = [];
        foreach (config('content.types') as $type) {
            if(!in_array($type, self::$exclude_types))
                $types_tmp[] = $type;
        }

        self::$types = $types_tmp;
    }

    protected function createComment($user,$type,$comment,$logout=false)
    {
		$content_id = Content::whereType($type)->orderBy('id', 'desc')->first()->id;

		$this->actingAs($user)->visit('/content/' . $type . '/'. $content_id)
		 	 ->see('comment_form_' . $type)
			 ->see(trans('comment.create.submit.title'))
			 ->type($comment,'body')
			 ->press(trans('comment.create.submit.title'))
			 ->see($comment)
			 ->seeInDatabase('comments', [
                	'user_id' => $user->id, 
                	'content_id' => $content_id,
                	'body' => $comment
            ]);
		
        if($logout)		 
		  $this->visit('/logout');		    	
    }

    public function test_regular_user_can_comment()
    {
        $logged_user = factory(App\User::class)->create([
                'verified' => 'true',
                'role' => 'regular'
        ]);

        $comment1 = "See on test kommentaar1";
        $comment2 = "See on test kommentaar2";

        foreach(self::$types as $type) {

            $content = Content::whereType($type)->orderBy('id', 'desc')->first();
            $this->createComment($logged_user,$type,$comment1);
            $comment_body = $content->comments()->orderBy('id', 'desc')->first()->body;
            $this->assertEquals($comment_body,$comment1);

            //is second comment
            $this->createComment($logged_user,$type,$comment2);
            $comment_body = $content->comments()->orderBy('id', 'desc')->first()->body;
            $this->assertEquals($comment_body,$comment2);
        }
    }

    public function test_author_and_admin_can_edit_comment()
    {
        $logged_user = factory(App\User::class)->create([
                'verified' => 'true',
                'role' => 'regular'
        ]);

        $admin = factory(App\User::class)->create([
                'verified' => 'true',
                'role' => 'admin'
        ]);

        foreach(self::$types as $type) {

            $comment_text  = "See on muudetav kommentaar";
            $comment_text2 = "See on uus muudetud kommentaar";
            $comment_text_admin = 'See on admini poolt muudetud kommentaar';

            $content = Content::whereType($type)->orderBy('id', 'desc')->first();
            $this->createComment($logged_user,$type,$comment_text); 
            $comment = $content->comments()->orderBy('id', 'desc')->first();
            $this->assertEquals($comment->body,$comment_text);

            $this->actingAs($logged_user)->visit('content/' .$type. '/'. $content->id)
                 ->see($comment_text)
                 ->see('comment_edit_'.$comment->id)
                 ->press('comment_edit_'.$comment->id)
                 ->seePageIs('comment/'.$comment->id.'/edit')
                 ->see($comment_text)
                 ->see(trans('comment.edit.submit.title'))
                 ->type($comment_text2,'body')
                 ->press(trans('comment.edit.submit.title'))
                 ->seePageIs('content/' .$type. '/'. $content->id)
                 ->see($comment_text2);

            $this->actingAs($admin)->visit('content/' .$type. '/'. $content->id)
                 ->see($comment_text2)
                 ->see('comment_edit_'.$comment->id)
                 ->press('comment_edit_'.$comment->id)
                 ->seePageIs('comment/'.$comment->id.'/edit')
                 ->see($comment_text2)
                 ->see(trans('comment.edit.submit.title'))
                 ->type($comment_text_admin,'body')
                 ->press(trans('comment.edit.submit.title'))
                 ->seePageIs('content/' .$type. '/'. $content->id)
                 ->see($comment_text_admin);

        }

    }

    public function test_anonymous_user_can_see_comments_but_not_comment()
    {
    	$logged_user = factory(App\User::class)->create([
                'verified' => 'true',
                'role' => 'regular'
        ]);

        $comment = "See on test kommentaar 1";

        foreach(self::$types as $type) {

        	//get newest item from every content type
        	$content = Content::whereType($type)->orderBy('id', 'desc')->first();
        	$this->createComment($logged_user,$type,$comment,true);

            //get new created comment
            $comment = $content->comments()->orderBy('id', 'desc')->first()->body;

            //visit as anonymous user
            $this->visit('/content/' . $type . '/'. $content->id)
                 ->dontSee('comment_form_' . $type)
                 ->see($comment);

        	
        }    
    }
}