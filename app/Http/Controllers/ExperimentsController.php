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
                collect()
                    ->push(
                        component('Section')
                            ->withBackground('gray-darker')
                            ->withPadding(1)
                            ->withInnerPadding(1)
                            ->withItems('Hello World')
                    )
                    ->push(
                        component('Section')
                            ->withBackground('red')
                            ->withInnerBackground('white')
                            ->withPadding(1)
                            ->withInnerPadding(1)
                            ->withItems('Hello World')
                    )
            )
            ->render();
    }
}
