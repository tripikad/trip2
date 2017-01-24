<?php

namespace App\Http\Controllers;

use Request;
use App\Content;

class V2ExperimentsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return layout('1col')

            ->with('content', collect()
                /*
                ->push(component('Form')
                    ->with('route', route('experiments.form'))
                    ->with('fields', collect()
                        ->push(component('FormTextarea')
                            ->with('name', 'body')
                        )
                        ->push(component('FormButton')
                            ->with('title', trans('comment.create.submit.title'))
                        )
                    )
                )
                */
                ->push(component('Title')
                    ->with('title', 'Vealehed')
                )

                ->push(component('MetaLink')
                    ->with('title', 'Error 401')
                    ->with('route', route('error.show', [401]))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Error 404')
                    ->with('route', route('error.show', [404]))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Error 500')
                    ->with('route', route('error.show', [500]))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Error 503')
                    ->with('route', route('error.show', [503]))
                )
                ->push(component('Title')
                    ->with('title', 'Staatilised lehed')
                )
                ->push(component('MetaLink')
                    ->with('title', 'Staatilised lehed')
                    ->with('route', route('static.index'))
                )

            )

            ->render();
    }

    public function form()
    {
        dump(request()->all());

        return back()->with('title', 'Submitted a form');
    }
}
