<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use View;
use DB;
use Cache;
use Auth;

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
        
        return response()->view('pages.frontpage.index', [
            'destinations' => $destinations,
            'features' => $features
        ])->header('Cache-Control', 'public, s-maxage=' . config('site.cache.frontpage'));
    }

    public function search(Request $request)
    {

        return redirect()
            ->route('destination.index', [$request->destination]);

    }

}
