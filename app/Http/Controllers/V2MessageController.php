<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use Log;
use Mail;
use Illuminate\Http\Request;

class V2MessageController extends Controller
{
    public function index($user_id)
    {
        $user = User::findorFail($user_id);
        $messages = collect($user->messages());

        return layout('1col')

            ->with('background', component('BackgroundMap'))
            ->with('color', 'cyan')

            ->with('header', region('UserHeader', $user))

            ->with('content', collect()
                ->push(component('Title')
                    ->with('title', trans('message.index.title'))
                )
                ->merge($messages->map(function ($message) use ($user) {
                    return region('MessageRow', $message, $user);
                }))
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function indexWith($user_id, $user_id_with)
    {
        $user = User::findorFail($user_id);
        $user_with = User::findorFail($user_id_with);

        $messages = $user->messagesWith($user_id_with);

        // Mark messages as read

        $messageIds = $user
            ->messagesWith($user_id_with)
            ->where('user_id_to', $user->id)
            ->keyBy('id')
            ->keys()
            ->toArray();

        Message::whereIn('id', $messageIds)->update(['read' => 1]);

        return layout('1col')

            ->with('background', component('BackgroundMap'))
            ->with('color', 'cyan')

            ->with('header', region('UserHeader', $user))

            ->with('content', collect()
                ->push(component('Title')
                    ->with('title', trans('message.index.with.title', [
                        'user_with' => $user_with->vars()->name,
                        'created_at' => $messages->count() ? $messages->last()->created_at : '',
                    ]))
                )
                ->merge($messages->flatMap(function ($message) use ($user) {
                    return collect()
                        ->push(region('MessageWithRow', $message))
                        ->push(component('Body')
                            ->is('responsive')
                            ->with('body', $message->vars()->body)
                        );
                }))
                ->push(region('MessageCreateForm', $user, $user_with))
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function store(Request $request, $user_id_from, $user_id_to)
    {
        $this->validate($request, ['body' => 'required']);

        $fields = ['user_id_from' => $user_id_from, 'user_id_to' => $user_id_to];

        $message = Message::create(array_merge($request->all(), $fields));

        $user_to = User::find($user_id_to);

        if ($user_to->notify_message) {
            $user_from = User::find($user_id_from);

            Mail::send('email.message.store', [
                'new_message' => $message, // 'message' variable is reseved by mailer
                'user_from' => $user_from,
                'user_to' => $user_to,
            ], function ($mail) use ($user_from, $user_to) {
                $mail->to($user_to->email)
                    ->subject(trans('message.store.email.subject', [
                        'user' => $user_from->name,
                    ]));

                $swiftMessage = $mail->getSwiftMessage();
                $headers = $swiftMessage->getHeaders();

                $header = [
                    'category' => [
                        'private_message',
                    ],
                    'unique_args' => [
                        'message_from_user_id' => (string) $user_from->id,
                        'message_to_user_id' => (string) $user_to->id,
                    ],
                ];

                $headers->addTextHeader('X-SMTPAPI', format_smtp_header($header));
            });
        }

        Log::info('A private message has been sent');

        return backToAnchor('#message-'.$message->id);
    
    }
}
