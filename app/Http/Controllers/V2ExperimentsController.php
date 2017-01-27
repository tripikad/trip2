<?php

namespace App\Http\Controllers;

use Request;
use App\Content;

class V2ExperimentsController extends Controller
{

    public function blogCreate()
    {
        $topics = \App\Topic::select('id', 'name')->orderBy('name')->get();

        return layout('1col')
            ->with('header', region('StaticHeader', collect()
                ->push(component('Title')
                    ->is('large')
                    ->with('title', 'Reisiblogid')
                )
            ))
            ->with('content', collect()
                ->push(component('Title')->with('title', 'Lisa blogipostitus'))
                ->push(component('Form')
                    ->with('route', route('experiments.blog.store'))
                    ->with('fields', collect()
                        ->push(component('FormTextfield')
                            ->with('label', 'Pealkiri')
                            ->with('name', 'title')
                            ->with('value', old('title'))
                        )
                        ->push(component('FormTextarea')
                            ->with('label', 'Sisu')
                            ->with('name', 'body')
                            ->with('value', old('title'))
                        )
                        ->push(component('FormSelectMultiple')
                            ->with('name', 'topics')
                            ->with('options', $topics)
                            ->with('value', [484,521])
                            ->with('placeholder', trans('content.index.filter.field.topic.title'))
                        )
                        ->push(component('FormTextfield')
                            ->with('label', 'Link')
                            ->with('name', 'url')
                            ->with('value', old('title'))
                        )
                        ->push(component('FormButton')
                            ->with('title', 'Lisa')
                        )
                    )
                )
            )
            ->render();
    }

    public function blogStore()
    {
        $fields = collect([
            'title' => 'required',
            'body' => 'required',
            'url' => 'url'
        ]);

        $this->validate(request(), $fields->all());

        Content::create(
            request($fields->keys()->all())
        );

        return back()->with('title', 'Submitted a form');
    }

    public function index()
    {
        $user = auth()->user();

        return layout('1col')

            ->with('header', region('StaticHeader', collect()
                ->push(component('Title')
                    ->is('large')
                    ->with('title', 'Reisiblogid')
                )
            ))

            ->with('content', collect()

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

}
