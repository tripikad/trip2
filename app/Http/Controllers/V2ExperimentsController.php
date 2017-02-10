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

                ->push(component('FormPhotoPicker')
                    ->with('title', 'Foto ID')
                )

                ->push(component('Title')
                    ->with('title', 'Auth forms')
                )

                ->push(component('MetaLink')
                    ->with('title', 'Login')
                    ->with('route', route('experiments.loginform'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Register')
                    ->with('route', route('experiments.registerform'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Remember password')
                    ->with('route', route('experiments.passwordform'))
                )
                ->push(component('MetaLink')
                    ->with('title', 'Reset password')
                    ->with('route', route('experiments.resetform'))
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

            )

            ->render();
    }
}
