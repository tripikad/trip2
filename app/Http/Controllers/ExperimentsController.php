<?php

namespace App\Http\Controllers;

use App\Content;
use App\Destination;
use DB;
use Carbon\Carbon;

class ExperimentsController extends Controller
{


    public function trip20Index()
    {
        $weblinks = DB::connection('trip')
            ->table('node')
            ->join('node_revisions', 'node_revisions.nid', '=', 'node.nid')
            ->join('weblink', 'weblink.nid', '=', 'node.nid')
            ->select('node.*', 'weblink.*')
            ->where('node.created', '<', Carbon::create(1999, 1, 1, 0, 0, 0)->timestamp)
            ->where('node.type', '=', 'weblink')
            ->take(100)
            ->get()
            ->map(function ($link) {
                $link->created = $link->created < 1 ? Carbon::create(1998, 1, 1, 0, 0, 0)->timestamp : $link->created;               
                return $link;
            })
            ->sortBy('created')
            ->map(function ($link) {
                $link->created = Carbon::createFromTimestamp($link->created)->format('j. M Y');
                $link->changed = Carbon::createFromTimestamp($link->changed)->format('j. M Y');
                $link->archivelink = 'https://web.archive.org/web/*/' . $link->weblink;
                return $link;
            });

            $images = Content::whereType('photo')
                ->orderBy('created_at', 'asc')
                ->take(100)
                ->skip(1600)
                ->get();
                //
                //->take(10)
                //->get()
            

            return layout('Two')
                ->with('content', $images->map(function($image) {
                    return component('Body')->with('body', format_body(collect()
                        ->push('####' . $image->title . ' ')
                        ->push('<img src=' . $image->imagePreset('medium') . ' />')
                        ->push('Original published at: ' . $image->created_at)
                        ->push('Added to Trip: ' . $image->updated_at)
                        ->implode("\n")));
                    }))
                ->render();

            return layout('Two')
                ->with('content', collect()
                    ->push(
                        component('Title')->with('title', 'Reisiartiklid Eesti ajalehtedes 1995-1998')
                    )
                    ->merge($weblinks->map(function($q) {
                        return component('Body')->with('body', format_body(collect()
                            ->push('####' .$q->title.' ')
                            ->push('['.$q->weblink.']('. $q->archivelink .')')
                            ->push('Original published at: '.$q->created)
                            ->push('Added to Trip: '.$q->changed)
                            ->implode("\n")
                        ));
                    }))
                )
                ->render();

    }

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
                    ->with('title', 'Fonts')
                    ->with('route', route('experiments.fonts.index'))
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
                    ->with('title', 'Grid')
                    ->with('route', route('experiments.layouts.grid'))
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

    public function fontsIndex()
    {
        return layout('Two')

            ->with('content', collect()
                ->push(component('ExperimentalFont'))
            )

            ->render();
    }
}
