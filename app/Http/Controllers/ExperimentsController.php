<?php

namespace App\Http\Controllers;

use App\Content;

class ExperimentsController extends Controller
{
    public function index()
    {
        $new = Content::whereTitle('Sierra Leone viisa saab nüüd piirilt')->first();

        return layout('Full')
            ->with(
                'items',
                collect()
                    ->push(
                        component('Section')
                            ->with('padding', 2)
                            ->with('inner_padding', 2)
                            ->with('background', 'blue')
                            ->with('inner_background', 'white')
                    )
                    ->push(
                        component('Section')
                            ->with('padding', 2)
                            ->with('height', '75vh')
                            ->with('image', $new->getHeadImage())
                            ->with('tint', true)
                            ->with(
                                'items',
                                collect()
                                    ->push(region('NavbarLight'))
                                    ->fill()
                                    ->push(
                                        component('Title')
                                            ->is('white')
                                            ->is('large')
                                            ->with('title', $new->vars()->title)
                                    )
                            )
                    )
                    ->push(
                        component('Section')
                            ->with('padding', 4)
                            ->with('width', styles('tablet-width'))
                            ->with(
                                'items',
                                component('Body')
                                    ->is('responsive')
                                    ->with('body', format_body($new->vars()->body))
                            )
                    )
            )
            ->render();
    }
}

/*



                        */
