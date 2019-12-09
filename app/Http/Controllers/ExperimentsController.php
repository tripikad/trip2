<?php

namespace App\Http\Controllers;

use App\Content;

class ExperimentsController extends Controller
{
    public function index()
    {
        $new = Content::whereTitle('Sierra Leone viisa saab nüüd piirilt')->first();

        $items = collect()
            ->push(region('NavbarLight'))
            ->spacer(10)
            ->push(component('Title')->with('title', 'Hello World'));

        return layout('Full')
            ->with(
                'items',
                collect()
                    ->push(
                        component('Container')
                            ->with('padding', 1)
                            ->with('height', '50vh')
                            ->with('valign', 'center')
                            ->with('image', $new->getHeadImage())
                            ->with('tint', true)
                            ->with(
                                'items',
                                collect()
                                    ->push(region('NavbarLight'))
                                    ->push(
                                        component('Title')
                                            ->is('white')
                                            ->with('title', $new->vars()->title)
                                    )
                            )
                    )
                    ->push(
                        component('Container')
                            ->with('padding', 4)
                            ->with('width', styles('tablet-width'))
                            ->with(
                                'items',
                                component('Body')
                                    ->is('responsive')
                                    ->with('body', format_body($new->vars()->body))
                            )
                    )
                    ->push(
                        component('Container')
                            ->with('background', 'blue')
                            ->with('items', [region('FooterLight', '')])
                    )
            )
            ->render();
    }
}

/*



                        */
