<?php

namespace App\Http\Regions;

class DestinationFacts {

    public function render($destination)
    {

        return component('DestinationFacts')
            ->with('description', trans("destination.show.description.$destination->id"));

    }

}
