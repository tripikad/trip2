<?php

namespace App\Http\Regions;

class BlogRow
{
    public function render($blog)
    {
        $commentCount = $blog->vars()->commentCount();
        $loggedUser = request()->user();

        return component('BlogRow')
            ->with('user', component('UserImage')
                ->with('route', route('user.show', [$blog->user]))
                ->with('image', $blog->user->imagePreset('small_square'))
                ->with('rank', $blog->user->vars()->rank)
                ->with('size', 72)
                ->with('border', 4)
            )
            ->with('title', $blog->vars()->title)
            ->with('route', route('blog.show', [$blog->slug]))
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
                        ->with('route', route('destination.showSlug', [$destination->slug]));
                }))
                ->merge($blog->topics->map(function ($topic) {
                    return component('MetaLink')->with('title', $topic->name);
                }))
                ->pushWhen($loggedUser && $loggedUser->hasRoleOrOwner('admin', $blog->user->id),
                    component('MetaLink')
                        ->with('title', trans('content.action.edit.title'))
                        ->with('route', route('blog.edit', [$blog]))
                )
                ->pushWhen($loggedUser && $loggedUser->hasRole('admin'), component('Form')
                        ->with('route', route(
                            'content.status',
                            [$blog->type, $blog, (1 - $blog->status)]
                        ))
                        ->with('fields', collect()
                            ->push(component('FormLink')
                                ->with(
                                    'title',
                                    trans("content.action.status.$blog->status.title")
                                )
                            )
                        )
                )
            )
        );
    }
}
