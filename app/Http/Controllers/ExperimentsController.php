<?php

namespace App\Http\Controllers;

use App\Content;

class ExperimentsController extends Controller
{
    public function index()
    {
        $new = Content::whereTitle('Sierra Leone viisa saab nüüd piirilt')->first();

        return layout('Full')
            ->with('items', [])
            ->render();
    }
}

/*



                        */
