<?php

namespace App\Http\Regions;

class DestinationHeaderAbout
{
    public function render($destination, $user)
    {
        return collect()
            ->push(
                component('Title')
                    ->is('large')
                    ->is('white')
                    ->with('title', $destination->name)
            )
            ->pushWhen(
                $user && $user->hasRole('admin'),
                component('Button')
                    ->is('small')
                    ->is('narrow')
                    ->with('title', trans('content.action.edit.title'))
                    ->with('route', route('destination.edit', [$destination]))
            )
            ->push(region('DestinationFacts', $destination))
            ->render()
            ->implode('<br />');
    }
}
