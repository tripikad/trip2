<?php

namespace App\Http\Regions;

class FrontpagePhotoSectionHeader
{
    public function render($loggedUser)
    {
        return component('Flex')
            ->withJustify('space-between')
            ->withAlign('center')
            ->withItems(
                collect()
                    ->push(
                        component('BlockTitle')
                            ->with('title', trans('frontpage.index.photo.title'))
                            ->with('route', route('photo.index'))
                    )
                    ->pushWhen(
                        $loggedUser && $loggedUser->hasRole('regular'),
                        component('Button')
                            ->is('narrow')
                            ->is('small')
                            ->with('title', trans('content.photo.create.title'))
                            ->with('route', route('photo.create'))
                    )
            );
    }
}
