<?php

namespace App\Http\Controllers;

use App\Image;
use App\Content;

class StaticController extends Controller
{
    public function show($slug)
    {
        $post = Content::findOrFail(config('static.slugs')[$slug]);

        $loggedUser = request()->user();

        return layout('Two')
            ->with('title', $post->vars()->title)
            ->with('head_title', $post->vars()->title)
            ->with('head_description', $post->vars()->description)
            ->with('head_image', Image::getSocial())

            ->with('background', component('BackgroundMap'))
            ->with('color', 'gray')

            ->with(
                'header',
                region('StaticHeader', collect()->push(component('Title')->with('title', $post->vars()->title)))
            )

            ->with(
                'content',
                collect()
                    ->push(
                        component('Body')
                            ->is('responsive')
                            ->with('body', $post->vars()->body)
                    )
                    ->pushWhen(
                        $loggedUser && $loggedUser->hasRoleOrOwner('admin', $post->user->id),
                        component('MetaLink')
                            ->with('title', trans('content.action.edit.title'))
                            ->with('route', route('static.edit', [$post]))
                    )
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }

    public function showId($id)
    {
        $slug = collect(config('static.slugs'))
            ->flip()
            ->get($id);

        return redirect()->route('static.show', [$slug]);
    }

    public function edit($id)
    {
        $static = Content::findOrFail($id);

        return layout('Two')
            ->with(
                'header',
                region('StaticHeader', collect()->push(component('Title')->with('title', $static->vars()->title)))
            )

            ->with(
                'content',
                collect()->push(
                    component('Form')
                        ->with('route', route('static.update', [$static]))
                        ->with(
                            'fields',
                            collect()
                                ->push(
                                    component('FormTextfield')
                                        ->is('large')
                                        ->with('title', trans('content.static.edit.field.title.title'))
                                        ->with('name', 'title')
                                        ->with('value', old('title', $static->title))
                                )
                                ->push(
                                    component('FormTextarea')
                                        ->with('title', trans('content.static.edit.field.body.title'))
                                        ->with('name', 'body')
                                        ->with('value', old('body', $static->body))
                                        ->with('rows', 20)
                                )
                                ->push(component('FormButton')->with('title', trans('content.edit.submit.title')))
                        )
                )
            )

            ->with('footer', region('FooterLight'))

            ->render();
    }

    public function update($id)
    {
        $static = Content::findOrFail($id);

        $rules = [
            'title' => 'required',
            'body' => 'required'
        ];

        $this->validate(request(), $rules);

        $static->update([
            'title' => request()->title,
            'body' => request()->body
        ]);

        return redirect()->route('static.show', collect(config('static.slugs'))->flip()[$static->id]);
    }
}
