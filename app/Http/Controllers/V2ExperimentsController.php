<?php

namespace App\Http\Controllers;

use App\Content;

class V2ExperimentsController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        return layout('1col')

            ->with('content', collect()

                ->push(component('Title')
                    ->with('title', 'Blog')
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

            )

            ->render();
    }
}
