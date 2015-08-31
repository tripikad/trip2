<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use View;
use DB;
use Cache;

use App\Content;
use App\Destination;

class FrontpageController extends Controller
{

    public function index()
    {

        $destinations = Destination::getNames();

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
                    
            $features[$type]['contents'] = Content::whereType($type)
                ->with(config("content_$type.frontpage.with"))
                ->latest(config("content_$type.frontpage.latest"))
                ->take(config("content_$type.frontpage.take"))
                ->get();
        
        }
        
        return Cache::rememberForever('frontpage.index', function() use ($destinations, $features) {

            return View::make('pages.frontpage.index')
                ->with('destinations', $destinations)
                ->with('features', $features)
                ->render();
        
        });

    }

    public function search(Request $request)
    {

        return redirect()
            ->route('destination.index', [$request->destination]);

    }

}
