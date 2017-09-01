<?php

namespace App\Mail;

use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewCommentFollow extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var Comment
     */
    public $comment;
    /**
     * @var int
     */
    public $user_id;

    /**
     * ConfirmRegistration constructor.
     * @param int $user_id
     * @param Comment $comment
     */
    public function __construct($user_id, Comment $comment)
    {
        $this->comment = $comment;
        $this->user_id = (int) $user_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject(
            trans('follow.content.email.subject', [
                'title' => $this->comment->content->title,
            ])
        )->markdown('email.follow.content');

        $header = [
            'category' => [
                'follow_content',
            ],
            'unique_args' => [
                'user_id' => (string) $this->user_id,
                'content_id' => (string) $this->comment->content->id,
                'content_type' => (string) $this->comment->content->type,
            ],
        ];

        $this->withSwiftMessage(function ($message) use ($header) {
            $message->getHeaders()
                ->addTextHeader('X-SMTPAPI', format_smtp_header($header));
        });
    }
}
