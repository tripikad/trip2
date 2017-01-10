<?php

namespace App\Http\Regions;

class BlogRow
{
    public function render($blog)
    {
        $commentCount = $blog->vars()->commentCount();

        return component('BlogRow')
            ->with('user', component('UserImage')
                ->with('route', route('v2.user.show', [$blog->user]))
                ->with('image', $blog->user->imagePreset('small_square'))
                ->with('rank', $blog->user->vars()->rank)
                ->with('size', 72)
                ->with('border', 4)
            )
            ->with('title', $blog->vars()->title)
            ->with('route', route('v2.blog.show', [$blog->slug]))
            ->with('meta', component('Meta')->with('items', collect()
                ->pushWhen($commentCount > 0, component('Tag')
                    ->with('title', trans_choice(
                        'comment.count',
                        $commentCount,
                        ['count' => $commentCount]
                    )
                ))
                ->push(component('MetaLink')
                    ->with('title', $blog->user->vars()->name)
                )
                ->push(component('MetaLink')
                    ->with('title', $blog->vars()->created_at)
                )
                ->merge($blog->destinations->map(function ($destination) {
                    return component('Tag')
                        ->is('orange')
                        ->with('title', $destination->name)
                        ->with('route', route('v2.destination.show', [$destination]));
                }))
                ->merge($blog->topics->map(function ($topic) {
                    return component('MetaLink')->with('title', $topic->name);
                }))
            )
        );
    }
}
