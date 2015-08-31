<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use View;
use Cache;

use App\Destination;

class DestinationController extends Controller
{

    public function index($id)
    {

        $destination =  Destination::with('flags', 'flags.user')
            ->findOrFail($id);

//        $image = $destination->content()->whereType('photo')->latest()->first();
        
        $types = [
            'news',
            'flight',
            'travelmate',
            'forum',
            'photo',
            'blog',
            'offer',
        ];

        $features = [];

        foreach ($types as $type) {
                    
            $features[$type]['contents'] = $destination->content()
                ->whereType($type)
                ->with(config("content_$type.frontpage.with"))
                ->latest(config("content_$type.frontpage.latest"))
                ->take(config("content_$type.frontpage.take"))
                ->get();
        
        }
        
        return Cache::rememberForever("destination.index.$destination->id", function() use ($destination, $features) {

            return View::make('pages.destination.index')
                ->with('destination', $destination)
                ->with('features', $features)
                ->render();
        
        });

    }

}