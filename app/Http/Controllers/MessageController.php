<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use View;
use App\Message;
use App\User;

class MessageController extends Controller
{
    public function index($user_id)
    {
        $user = User::findorFail($user_id);

        return View::make('pages.message.index')
            ->with('user', $user)
            ->render();
    }

    public function indexWith($user_id, $user_id_with)
    {
        $user = User::findorFail($user_id);
        $user_with = User::findorFail($user_id_with);

        $messages = $user->messagesWith($user_id_with);

        $messageIds = $user
            ->messagesWith($user_id_with)
            ->where('user_id_to', $user->id)
            ->keyBy('id')
            ->keys()
            ->toArray();

        Message::whereIn('id', $messageIds)->update(['read' => 1]);

        return View::make('pages.message.with')
            ->with('user', $user)
            ->with('user_with', $user_with)
            ->with('messages', $messages)
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

            Mail::queue('email.message.store', [
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

        return redirect()->route('message.index.with', [
            $user_id_from, $user_id_to, '#message-'.$message->id,
        ]);
    }
}
