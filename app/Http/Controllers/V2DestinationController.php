<?php

namespace App\Http\Controllers;

use App\Destination;

class V2DestinationController extends Controller
{
    public function show($id)
    {
        $destination = Destination::findOrFail($id);

        return view('v2.layouts.1col')

            ->with('header', region('DestinationMasthead', $destination))

            ->with('content', collect()
                ->push(component('Block')->with('content', collect(['NewsFilter'])))
            )

            ->with('bottom', collect()
                ->push(component('Promo')->with('promo', 'footer'))
            )

            ->with('footer', region('Footer'));
    }
}
