<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\Message;

class MessageTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @expectedException PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Received status code [401]
     */
    public function test_unlogged_user_can_not_see_messages()
    {
        $user1 = factory(App\User::class)->create();
        $user2 = factory(App\User::class)->create();

        $this->visit("user/$user1->id")
            ->dontSee(trans('user.show.message.create'));

        // Return 401

        $this->visit("user/$user1->id/messages")
            ->visit("user/$user1->id/messages/$user2->id");
    }

    /**
     * @expectedException PHPUnit_Framework_ExpectationFailedException
     * @expectedExceptionMessage Received status code [401]
     */
    public function test_regular_user_can_not_see_other_user_messages()
    {
        $user1 = factory(App\User::class)->create();
        $user2 = factory(App\User::class)->create();
        $user3 = factory(App\User::class)->create();

        $message = factory(Message::class)->create([
            'user_id_from' => $user1->id,
            'user_id_to' => $user2->id,
        ]);

        $this->actingAs($user3)
            ->visit("user/$user1->id")
            ->dontSeeLink(trans('menu.user.message'), 'user/'.$user1->id.'/messages');

        // Return 401

        $this->actingAs($user3)
            ->visit("user/$user1->id/messages")
            ->visit("user/$user1->id/messages/$user2->id");
    }

    public function test_regular_user_can_send_and_receive_message()
    {
        $user1 = factory(App\User::class)->create();
        $user2 = factory(App\User::class)->create();
        $user3 = factory(App\User::class)->create();

        // Sending a message

        $this->actingAs($user1)
            ->visit("user/$user2->id")
            ->click(trans('user.show.message.create'))
            ->seePageIs("user/$user1->id/messages/$user2->id")
            ->type('Hello', 'body')
            ->press(trans('message.create.submit.title'))
            ->seePageIs("user/$user1->id/messages/$user2->id")
            ->see('Hello');

        $this->seeInDatabase('messages', [
            'user_id_from' => $user1->id,
            'user_id_to' => $user2->id,
            'body' => 'Hello',
        ]);

        // Sender going back to messages page

        $this->actingAs($user1)
            ->visit("user/$user1->id")
            ->click(trans('menu.user.message'))
            ->seePageIs("user/$user1->id/messages")
            ->seeLink('Hello')
            ->seeLink($user2->name)
            ->click('Hello')
            ->seePageIs("user/$user1->id/messages/$user2->id");

        // Recipient receiving and replying a message

        $this->actingAs($user2)
            ->visit("user/$user2->id")
            ->click(trans('menu.user.message'))
            ->seePageIs("user/$user2->id/messages")
            ->seeLink('Hello')
            ->see($user1->name)
            ->click('Hello')
            ->seePageIs("user/$user2->id/messages/$user1->id")
            ->see('Hello')
            ->see($user1->name)
            ->type('World', 'body')
            ->press(trans('message.create.submit.title'))
            ->seePageIs("user/$user2->id/messages/$user1->id")
            ->see('World');

        $this->seeInDatabase('messages', [
            'user_id_from' => $user2->id,
            'user_id_to' => $user1->id,
            'body' => 'World',
        ]);

        // Sender receiving a reply

        $this->actingAs($user1)
            ->visit("user/$user1->id/messages")
            ->seeLink('World')
            ->see($user2->name)
            ->click('World')
            ->seePageIs("user/$user1->id/messages/$user2->id")
            ->see('World')
            ->see($user2->name);
    }

    public function test_regular_user_can_receive_messages_from_different_senders()
    {
        $user1 = factory(App\User::class)->create(['verified' => true]);
        $user2 = factory(App\User::class)->create(['verified' => true]);
        $user3 = factory(App\User::class)->create(['verified' => true]);

        factory(Message::class)->create([
            'user_id_from' => $user1->id,
            'user_id_to' => $user3->id,
            'body' => 'Hello',
        ]);

        factory(Message::class)->create([
            'user_id_from' => $user2->id,
            'user_id_to' => $user3->id,
            'body' => 'World',
        ]);

        $this->actingAs($user3)
            ->visit("user/$user3->id/messages")
            ->seeLink('Hello')
            ->see($user1->name)
            ->seeLink('World')
            ->see($user2->name)
            ->click('Hello')
            ->seePageIs("user/$user3->id/messages/$user1->id")
            ->see('Hello')
            ->see($user1->name)
            ->dontSee('World')
            ->dontSee($user2->name);
    }
}
