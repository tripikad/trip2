<?php

namespace App\Mail;

use App\User;
use App\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewMessage extends Mailable implements ShouldQueue
{
  use Queueable, SerializesModels;

  /**
   * The order instance.
   *
   * @var User
   */
  public $user_from;

  /**
   * @var User
   */
  public $user_to;

  /**
   * @var User
   */
  public $new_message;

  /**
   * ConfirmRegistration constructor.
   * @param User $user_from
   * @param User $user_to
   * @param Message $message
   */
  public function __construct(User $user_from, User $user_to, Message $message)
  {
    $this->user_from = $user_from;
    $this->user_to = $user_to;
    $this->new_message = $message;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    $this->subject(
      trans('message.store.email.subject', [
        'user' => $this->user_from->name
      ])
    )->markdown('email.message.store');

    $header = [
      'category' => ['private_message'],
      'unique_args' => [
        'message_from_user_id' => (string) $this->user_from->id,
        'message_to_user_id' => (string) $this->user_to->id
      ]
    ];

    $this->withSwiftMessage(function ($message) use ($header) {
      $message->getHeaders()->addTextHeader('X-SMTPAPI', format_smtp_header($header));
    });
  }
}
