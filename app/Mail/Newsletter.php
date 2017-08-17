<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Newsletter extends Mailable
{
    use Queueable, SerializesModels;

    public $body;
    public $heading;
    public $category;
    public $user_id;
    public $unsubscribe_route;

    public function __construct($body, $heading, $category, $user_id, $unsubscribe_route)
    {
        $this->body = $body;
        $this->heading = $heading;
        $this->category = $category;
        $this->user_id = $user_id;
        $this->unsubscribe_route = $unsubscribe_route;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject($this->heading)
            ->markdown('email.newsletter.newsletter');

        $header = [
            'category' => [
                $this->category,
            ],
            'unique_args' => [
                'user_id' => (string) $this->user_id,
            ],
        ];

        $this->withSwiftMessage(function ($message) use ($header) {
            $message->getHeaders()
                ->addTextHeader('X-SMTPAPI', format_smtp_header($header));
        });
    }
}
