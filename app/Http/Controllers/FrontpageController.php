<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use View;
use DB;

use App\Content;

class FrontpageController extends Controller
{

    public function index()
    {

        $fronts = [];

        foreach (config('content.types') as $type => $typeConf) {
        
            if (isset($typeConf['front'])) {

                $fronts[$type]['title'] = $typeConf['title'];
            
                $fronts[$type]['contents'] = Content::whereType($type)
                    ->with($typeConf['with'])
                    ->latest($typeConf['latest'])
                //  ->orderBy(DB::raw('RAND()'))
                    ->take($typeConf['frontpaginate'])
                    ->get();
        
            }
        
        }
        
            return View::make('pages.frontpage.index')
                ->with('fronts', $fronts)
                ->render();
        
    }

}
