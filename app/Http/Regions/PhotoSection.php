<?php

namespace App\Http\Regions;

class PhotoSection
{
    public function render($photos, $loggedUser)
    {
        return component('Section')
            ->withHeight(15)
            ->withBackground('gray-darker')
            ->withMargin(0)
            ->withWidth('100%')
            ->withItems(
                component('Flex')
                    ->withGap(0)
                    ->withScroll(true)
                    ->withResponsive(false)
                    ->withItems(
                        $photos->map(function ($photo) use ($loggedUser) {
                            return component('Photo')
                                ->vue()
                                ->is($photo->status ? '' : 'dimmed')
                                ->withImage($photo->imagePreset('small_square'))
                                ->withLargeImage($photo->imagePreset('large'))
                                ->withMeta(
                                    component('Flex')
                                        ->withJustify('center')
                                        ->withItems(
                                            collect()
                                                ->push(
                                                    component('Title')
                                                        ->is('smallest')
                                                        ->is('blue')
                                                        ->withTitle($photo->user->name)
                                                        ->withRoute(route('user.show', [$photo->user]))
                                                        ->withExternal(true)
                                                )
                                                ->push(
                                                    component('Title')
                                                        ->is('smallest')
                                                        ->is('white')
                                                        ->withTitle($photo->title)
                                                )
                                                ->pushWhen(
                                                    $loggedUser && $loggedUser->hasRole('admin'),
                                                    component('PublishButton')
                                                        ->withPublished($photo->status)
                                                        ->withPublishRoute(
                                                            route('content.status', [$photo->type, $photo, 1])
                                                        )
                                                        ->withUnpublishRoute(
                                                            route('content.status', [$photo->type, $photo, 0])
                                                        )
                                                )
                                        )
                                        ->render()
                                );
                        })
                    )
            );
    }
}
