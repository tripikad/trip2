<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use Cache;
use App\Content;
use App\Destination;
use App\Main;
//use Illuminate\Support\Collection;
use DB;

class FrontpageController extends Controller
{
    public function index()
    {
        $destinations = Destination::getNames();

        $types = [
            'flights1' => [
                'skip' => null,
                'take' => 3,
                'type' => ['flight'],
                'status' => 1,
                'latest' => 'created_at',
                'whereBetween' =>  Main::getExpireData('flight', 1),
            ],
            'flights2' => [
                'skip' => 3,
                'take' => 5,
                'type' => ['flight'],
                'status' => 1,
                'latest' => 'created_at',
                'whereBetween' => Main::getExpireData('flight', 1),
            ],
            'content' => [
                'take' => 1,
                'id' => 1534,
                'status' => 1,
            ],
            'forums' => [
                'skip' => null,
                'take' => 5,
                'type' => ['forum', 'buysell', 'expat'],
                'status' => 1,
                'latest' => 'created_at',
                'whereBetween' =>
                    Main::getExpireData('buysell', 1) +
                    ['only' => 'buysell'],
            ],
            'news' => [
                'skip' => null,
                'take' => 8,
                'type' => ['news'],
                'status' => 1,
                'latest' => 'created_at',
            ],
            'featured_news' => [
                'skip' => null,
                'take' => 3,
                'type' => ['sponsored'],
                'status' => 1,
                'latest' => 'created_at',
            ],
            'blogs' => [
                'skip' => null,
                'take' => 1,
                'type' => ['blog'],
                'status' => 1,
                'latest' => 'created_at',
            ],
            'photos' => [
                'skip' => null,
                'take' => 8,
                'type' => ['photo'],
                'status' => 1,
                'latest' => 'created_at',
            ],
            'travelmates' => [
                'skip' => null,
                'take' => 3,
                'type' => ['travelmate'],
                'status' => 1,
                'latest' => 'created_at',
                'whereBetween' =>  Main::getExpireData('travelmate', 1),
            ],
        ];

        $viewVariables = Main::getContentCollections($types);

        $viewVariables['destinations'] = $destinations;

        $getParentDestinations = [
            'flights1',
        ];
        $viewVariables = Main::getParentDestinations($getParentDestinations, $viewVariables);

        return response()
            ->view('pages.frontpage.index', $viewVariables)
            ->header('Cache-Control', 'public, s-maxage='.config('cache.frontpage.header'));
    }

    public function search(Request $request)
    {
        return redirect()
            ->route('destination.index', [$request->destination]);
    }
}
