<?php

namespace App\Http\Regions;

class MessageWithRow
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
            ->with(
                'title',
                $message->fromUser->vars()->name.' '.$message->vars()->created_at
            );
    }
}
