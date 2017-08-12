<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
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
        $this->subject(trans('auth.reset.email.subject'))
            ->markdown('email.auth.reset');

        $header = [
            'category' => [
                'auth_reset',
            ],
            'unique_args' => [
                'user_id' => (string) $this->user->id,
            ],
        ];

        $this->withSwiftMessage(function ($message) use ($header) {
            $message->getHeaders()
                ->addTextHeader('X-SMTPAPI', format_smtp_header($header));
        });
    }
}
