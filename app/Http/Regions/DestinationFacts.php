<?php

namespace App\Http\Regions;

class DestinationFacts
{
    public function render($destination)
    {
        return collect()
            ->push(component('DestinationFacts')
                ->with('facts', collect()
                    ->putWhen(
                        $destination->vars()->isCountry || $destination->vars()->isPlace,
                        trans('destination.show.about.callingCode'),
                        $destination->vars()->callingCode()
                    )
                    ->putWhen(
                        $destination->vars()->isCountry || $destination->vars()->isPlace,
                        trans('destination.show.about.currencyCode'),
                        $destination->vars()->currencyCode()
                    )
                )
            )
            ->push(component('DestinationFacts')
                ->with('facts', collect()
                    ->putWhen(
                        $destination->vars()->isCountry,
                        trans('destination.show.about.area'),
                        $destination->vars()->area()
                    )
                    ->putWhen(
                        $destination->vars()->isCountry,
                        trans('destination.show.about.population'),
                        $destination->vars()->population()
                    )
                )
            )
            ->render()
            ->implode('');
    }
}
