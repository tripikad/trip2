<?php

namespace App\Http\Regions;

class ShortnewsCard
{
    public function render($post)
    {
        $commentCount = $post->vars()->commentCount();

        return component('NewsCard')
            ->with('route', route($post->type.'.show', [$post->slug]))
            ->with('image', $post->imagePreset('small'))
            ->with('title', $post->vars()->shortTitle)
            ->with('meta', component('Meta')
                ->with('items', collect()
                    ->push(component('MetaLink')
                        ->with('title', $post->vars()->created_at)
                    )
                    ->pushWhen($commentCount > 0, component('Tag')
                        ->with('title', trans_choice(
                                'comment.count',
                                $commentCount,
                                ['count' => $commentCount]
                            )
                        ))
                )
            );
    }
}
