<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use View;
use Cache;
//use App\Content;
//use App\Destination;
//use App\Main;
//use DB;

class SearchController extends Controller
{
    public function show()
    {
        $viewVariables = [];

        return response()
            ->view('pages.search.show', $viewVariables)
            ->header('Cache-Control', 'public, s-maxage='.config('cache.search.header'));
    }
}
