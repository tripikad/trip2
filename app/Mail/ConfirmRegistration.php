<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmRegistration extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The order instance.
     *
     * @var User
     */
    public $user;

    /**
     * ConfirmRegistration constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject(trans('auth.register.email.subject'))->markdown('email.auth.register');

        $header = [
            'category' => ['auth_register'],
            'unique_args' => [
                'user_id' => (string) $this->user->id
            ]
        ];

        $this->withSwiftMessage(function ($message) use ($header) {
            $message->getHeaders()->addTextHeader('X-SMTPAPI', format_smtp_header($header));
        });
    }
}
