<?php

namespace App\Http\Controllers;

use App\Content;
use App\Destination;

class V2ExperimentsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return layout('1col')

            ->with('content', collect()

                ->push(component('Title')
                    ->with('title', 'New forms')
                )

                ->push(component('MetaLink')
                    ->with('title', 'Forum: Create')
                    ->with('route', route('experiments.forum.create'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Travelmate: Create')
                    ->with('route', route('experiments.travelmate.create'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Photo: Create')
                    ->with('route', route('experiments.photo.create'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'User: Edit')
                    ->with('route', route('experiments.user.edit'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'User: Destinations')
                    ->with('route', route('experiments.user.destinations'))
                )

                ->push(component('Title')
                    ->with('title', 'Blogs')
                )

                ->push(component('MetaLink')
                    ->with('title', 'Blog: index')
                    ->with('route', route('experiments.blog.index'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Blog: show')
                    ->with('route', route('experiments.blog.show'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Blog: edit')
                    ->with('route', route('experiments.blog.edit'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Blog: profile')
                    ->with('route', route('experiments.blog.profile'))
                )

                ->push(component('Title')
                    ->with('title', 'Misc')
                )

                ->push(component('MetaLink')
                    ->with('title', 'Selects')
                    ->with('route', route('experiments.select.index'))
                )

                ->push(component('MetaLink')
                    ->with('title', 'Fonts')
                    ->with('route', route('experiments.fonts.index'))
                )

                ->push(component('MetaLink')
                    ->with('title', 'Map')
                    ->with('route', route('experiments.map.index'))
                )

            )

            ->render();
    }

    public function selectIndex()
    {
        $destinations = Destination::select('id', 'name')->orderBy('name', 'asc')->get();

        return layout('1col')

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
        return layout('1col')

            ->with('content', collect()
                ->push(component('Dotmap')
                    ->with('dots', config('dots'))
                )
            )

        ->render();
    }

    public function fontsIndex()
    {
        return layout('1col')

            ->with('content', collect()
                ->push(component('FontExperiment'))
            )

            ->render();
    }
}
