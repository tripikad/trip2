<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use View;
use DB;

use App\Content;
use App\Destination;

class FrontpageController extends Controller
{

    public function index()
    {

        $fronts = [];

        foreach (config('content.types') as $type) {
        
            if (config("content_$type.frontpage.show")) {
            
                $fronts[$type]['contents'] = Content::whereType($type)
                    ->with(config("content_$type.index.with"))
                    ->latest(config("content_$type.index.latest"))
                    ->take(config("content_$type.frontpage.paginate"))
                    ->get();
        
            }
        
        }
        
        $destinations = Destination::getNames();

        return View::make('pages.frontpage.index')
            ->with('destinations', $destinations)
            ->with('fronts', $fronts)
            ->render();
        
    }

    public function search(Request $request)
    {

        return redirect()
            ->route('destination.index', [$request->destination]);

    }

}
