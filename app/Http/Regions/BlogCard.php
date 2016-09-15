<?php

namespace App\Http\Regions;

class BlogCard {

    public function render($blog)
    {

        return component('BlogCard')
            ->with('title', $blog->title)
            ->with('route', route('content.show', [$blog->type, $blog]))
            ->with('user', component('UserImage')
                ->with('route', route('user.show', [$blog->user]))
                ->with('image', $blog->user->imagePreset('small_square'))
                ->with('rank', $blog->user->vars()->rank)
            )
            ->with('meta', component('Meta')->with('items', collect()
                ->push(component('MetaLink')
                    ->with('title', $blog->user->vars()->name)
                    ->with('route', route('user.show', [$blog->user]))
                ))
            );

    }

}
