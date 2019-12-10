<?php

namespace App\Http\Controllers;

use App\Content;

class ExperimentsController extends Controller
{
    public function index()
    {
        $photos = Content::getLatestPagedItems('photo', 10, 1);

        return layout('Full')
            ->withItems(
                component('Section')->withItems(
                    component('Flex')
                        ->withWrap(true)
                        ->withItems()
                )
            )
            ->render();
    }
}

/*



                        */
