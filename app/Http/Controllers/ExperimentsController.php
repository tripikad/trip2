<?php

namespace App\Http\Controllers;

use App\Destination;

class ExperimentsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return layout('Two')

            ->with('content', collect()

                ->push(component('Title')
                    ->with('title', 'Code')
                )

                ->push(component('Code')
                    ->is('gray')
                    ->with('code', "Hello\nworld")
                )

                ->push(component('Title')
                    ->with('title', 'Small editor')
                )

                ->push(component('EditorSmall')
                    ->with('value', 'Testing it out')
                )

                ->push(component('Title')
                    ->with('title', 'Misc')
                )

                ->push(component('MetaLink')
                    ->with('title', 'Selects')
                    ->with('route', route('experiments.select.index'))
                )

                ->push(component('MetaLink')
                    ->with('title', 'Map')
                    ->with('route', route('experiments.map.index'))
                )

                ->push(component('Title')
                    ->with('title', 'Layouts')
                )

                ->push(component('MetaLink')
                    ->with('title', 'One')
                    ->with('route', route('experiments.layouts.one'))
                )

                ->push(component('MetaLink')
                    ->with('title', 'Two')
                    ->with('route', route('experiments.layouts.two'))
                )

                ->push(component('MetaLink')
                    ->with('title', 'Frontpage')
                    ->with('route', route('experiments.layouts.frontpage'))
                )

            )

            ->render();
    }

    public function selectIndex()
    {
        $destinations = Destination::select('id', 'name')->orderBy('name', 'asc')->get();

        return layout('Two')

            ->with('content', collect()

                ->push(component('Form')
                    ->with('route', route('experiments.select.create'))
                    ->with('fields', collect()
                        ->push(component('FormSelectMultiple')
                            ->with('name', 'destinations1')
                            ->with('options', $destinations)
                            ->with('value', [1])
                            ->with('placeholder', trans('content.edit.field.destinations.placeholder'))
                        )
                        ->push(component('FormSelectMultiple')
                            ->with('name', 'destinations2')
                            ->with('options', $destinations)
                            ->with('value', [2, 3])
                            ->with('placeholder', trans('content.edit.field.destinations.placeholder'))
                        )
                        ->push(component('FormSelect')
                            ->with('name', 'destination1')
                            ->with('options', $destinations)
                            ->with('value', 4)
                            ->with('placeholder', trans('content.edit.field.destinations.placeholder'))
                        )
                        ->push(component('FormSelect')
                            ->with('name', 'destination2')
                            ->with('options', $destinations)
                            ->with('value', 5)
                            ->with('placeholder', trans('content.edit.field.destinations.placeholder'))
                        )
                        ->push(component('FormButton')
                            ->with('title', trans('content.edit.submit.title'))
                        )
                    )
                )
            )

            ->render();
    }

    public function selectCreate()
    {
        dump(request()->all());
    }

    public function mapIndex()
    {
        return layout('Two')

            ->with('content', collect()
                ->push(component('Dotmap')
                    ->with('dots', config('dots'))
                )
            )

        ->render();
    }
}
