<?php

namespace App\Http\Regions;

class CommentCreateForm
{
    public function render($content)
    {
        return component('Block')
            ->is('border')
            ->with('content', collect()
                ->push(component('Form')
                    ->with('route', route('comment.store', [$content->type, $content->id]))
                    ->with('fields', collect()
                        ->push(component('FormTextarea')
                            ->is('borderless')
                            ->with('name', 'body')
                            ->with('placeholder', trans('comment.create.field.body.title'))
                        )
                        ->push(component('FormButton')
                            ->with('title', trans('comment.create.submit.title'))
                        )
                    )
                )
            );
    }
}
