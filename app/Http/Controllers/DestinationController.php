<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use View;

use App\Destination;

class DestinationController extends Controller
{

    public function index($id)
    {

        $destination =  Destination::findOrFail($id);

        $image = $destination->content()->whereType('photo')->first();
        
        return View::make('pages.destination.index')
            ->with('destination', $destination)
            ->with('image', $image->imagePath())
            ->render();


/*
        $fronts = [];

        foreach (config('content.types') as $type => $typeConf) {
        
            if (isset($typeConf['front'])) {

                $contents =  $destination->content()
                    ->whereType($type)
                    ->with($typeConf['with'])
                    ->latest($typeConf['latest'])
                    ->take($typeConf['frontpaginate'])
                    ->get();
        
                if ($contents) $fronts[$type]['contents'] = $contents;
            }
        
        }
        
        return View::make('pages.frontpage.index')
            ->with('title', $destination->name)
            ->with('fronts', $fronts)
            ->render();

        */

    }

}