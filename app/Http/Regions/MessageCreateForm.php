<?php

namespace App\Http\Regions;

class MessageCreateForm
{
    public function render($user, $user_with)
    {
        return component('Block')
            ->is('white')
            ->with('content', collect()
                ->push(component('Form')
                    ->with('route', route('message.store', [$user, $user_with]))
                    ->with('fields', collect()
                        ->push(component('FormTextarea')
                            ->with('name', 'body')
                            ->with('placeholder', trans('message.create.field.body.title'))
                        )
                        ->push(component('FormButton')
                            ->with('title', trans('message.create.submit.title'))
                        )
                    )
                )
            );
    }
}
