<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use View;
use Cache;
use App\Destination;
use App\Main;
use App\Content;

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
                'whereBetween' =>  Main::getExpireData('flight'),
            ],
            'flights2' => [
                'skip' => 3,
                'take' => 5,
                'type' => ['flight'],
                'status' => 1,
                'latest' => 'created_at',
                'whereBetween' => Main::getExpireData('flight'),
            ],
            'content' => [
                'take' => 1,
                'id' => 1534,
                'status' => 1,
            ],
            'forums' => [
                'skip' => null,
                'take' => 12,
                'type' => ['forum', 'buysell', 'expat'],
                'status' => 1,
                'latest' => 'updated_at',
                'whereBetween' => Main::getExpireData('buysell') +
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
                'take' => 3,
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
                'whereBetween' =>  Main::getExpireData('travelmate'),
            ],
        ];

        $viewVariables = Main::getContentCollections($types);

        $viewVariables['destinations'] = $destinations;

        $viewVariables['forums'] = Content::IsNewContent($viewVariables['forums']);

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
            ->route('destination.show', [$request->destination]);
    }
}
