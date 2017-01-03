<?php

namespace App\Http\Regions;

class MessageRow
{

    public function render($message)
    {

        return component('MessageRow')
            ->with('user', component('UserImage')
                ->with('route', route('v2.user.show', [$message->fromUser]))
                ->with('image', $message->fromUser->vars()->imagePreset('small_square'))
                ->with('rank', $message->fromUser->vars()->rank)
                ->with('size', 36)
                ->with('border', 3)
            )
            ->with('title', trans('message.index.with.row.description', [
                'user' => $message->fromUser->vars()->name,
                'created_at' => $message->vars()->created_at
            ]))
            ->with('body', component('body')
                ->with('body', $message->body)
            );

    }

}
