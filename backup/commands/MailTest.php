<?php

namespace App\Console\Commands;

use Mail;
use Illuminate\Console\Command;

class MailTest extends Command
{
    protected $signature = 'mail:test';

    public function handle()
    {
        Mail::raw('Test email', function ($message) {
            $message->to('sink@sink.sendgrid.net')
                    ->subject('Mail test');

            $swiftMessage = $message->getSwiftMessage();
            $headers = $swiftMessage->getHeaders();

            $header = [
                    'category' => [
                        'follow_content',
                    ],
                    'unique_args' => [
                        'test_id' => '1',
                    ],
                ];

            $headers->addTextHeader('X-SMTPAPI', format_smtp_header($header));
        });
    }
}
