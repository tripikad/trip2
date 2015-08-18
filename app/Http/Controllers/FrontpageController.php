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

        foreach (config('content.types') as $type => $typeConf) {
        
            if (isset($typeConf['front'])) {
            
                $fronts[$type]['contents'] = Content::whereType($type)
                    ->with($typeConf['with'])
                    ->latest($typeConf['latest'])
                    ->take($typeConf['frontpaginate'])
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
