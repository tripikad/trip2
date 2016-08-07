<?php

namespace App\Http\Regions;

use Illuminate\Http\Request;

class CommentCreateForm {

    public function render(Request $request, $content)
    {

        return component('Block')
            ->with('title', trans('comment.create.title'))
            ->with('content', collect()
                ->push(component('Form')
                    ->with('route', route('comment.store', [$content->type, $content->id]))
                    ->with('fields', collect()
                        ->push(component('FormTextarea')
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