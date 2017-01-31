<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;

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
}
