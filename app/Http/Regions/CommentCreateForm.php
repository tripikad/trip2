<?php

namespace App\Http\Regions;

class CommentCreateForm
{
    public function render($content, $is = '')
    {
        return component('Block')
            ->is('border')
            ->is($is)
            ->with('content', collect()
                ->push(component('Form')
                    ->with('route', route(
                        'comment.store',
                        [$content->type, $content->id]
                    ))
                    ->with('id', 'CommentCreateForm')
                    ->with('fields', collect()
                        ->push(component('FormTextarea')
                            ->is('borderless')
                            ->with('name', 'body')
                            ->with('placeholder', trans('comment.create.field.body.title'))
                        )
                        ->push(component('FormButton')
                            ->is('hidden')
                            ->with('title', trans('comment.create.submit.title'))
                        )
                        ->push(component('FormButtonProcess')
                            ->with('title', trans('comment.create.submit.title'))
                            ->with('processingtitle', trans('comment.create.submitting.title'))
                            ->with('id', 'CommentCreateForm')
                        )
                    )
                )
            );
    }
}
