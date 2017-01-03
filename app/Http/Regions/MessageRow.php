<?php

namespace App\Http\Regions;

class MessageRow
{
    public function render($message, $user)
    {
        return component('MessageRow')
            ->with('title', trans('message.index.row.description', [
                'user' => $message->withUser->vars()->name,
                'created_at' => $message->vars()->created_at,
            ]))
            ->with('user', component('UserImage')
                ->with('route', route('v2.user.show', [$message->withUser]))
                ->with('image', $message->withUser->vars()->imagePreset('small_square'))
                ->with('rank', $message->withUser->vars()->rank)
                ->with('size', 32)
                ->with('border', 3)
            )
            ->with('route', route(
                'v2.message.index.with',
                [$user, $message->withUser])
            );
    }
}
