<?php

namespace App\Http\Controllers;

use Log;
use Auth;
use App\Content;
use Illuminate\Http\Request;

class V2MiscController extends Controller
{
    protected $rules = [
            'type' => 'required',
            'title' => 'required',
            'body' => 'required',
        ];

    public function create()
    {
        return layout('2col')

            ->with('narrow', true)

            ->with('background', component('BackgroundMap'))
            ->with('color', 'gray')

            ->with('header', region('ForumHeader', collect()
                ->push(component('Title')
                    ->is('gray')
                    ->with('title', trans('content.forum.index.title'))
                    ->with('route', route('forum.index'))
                )
                ->push(component('BlockHorizontal')
                    ->with('content', region('ForumLinks'))
                )
            ))

            ->with('content', collect()
                ->push(component('Title')
                    ->with('title', trans('content.misc.create.title'))
                )
                ->push(component('Form')
                    ->with('id', 'ForumCreateForm')
                    ->with('route', route('forum.store.misc'))
                    ->with('fields', collect()
                        // TODO: replace with hidden field
                        ->push(component('FormHidden')
                            ->with('name', 'type')
                            ->with('value', 'misc')
                        )
                        ->push(component('FormTextfield')
                            ->is('large')
                            ->with('title', trans('content.forum.edit.field.title.title'))
                            ->with('name', 'title')
                            ->with('value', old('title'))
                        )
                        ->push(component('FormTextarea')
                            ->with('title', trans('content.forum.edit.field.body.title'))
                            ->with('name', 'body')
                            ->with('value', old('title'))
                            ->with('rows', 20)
                        )
                        ->push(component('FormButton')
                            ->is('hidden')
                            ->with('title', trans('content.create.submit.title'))
                        )
                        ->push(component('FormButtonProcess')
                            ->with('id', 'ForumCreateForm')
                            ->with('title', trans('content.create.submit.title'))
                            ->with('processingtitle', trans('content.create.submitting.title'))
                        )
                    )
                )
            )

            ->with('sidebar', collect()
                ->push(component('Block')
                    ->is('gray')
                    ->with('content', collect()
                        ->push(component('Title')
                            ->is('smaller')
                            ->is('red')
                            ->with('title', trans('content.misc.edit.notes.heading'))
                            ->with('route', route('forum.index'))
                        )
                        ->push(component('Body')
                            ->with('body', trans('content.misc.edit.notes.body'))
                        )
                    ))
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $type = $request->type;

        $content = Content::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'body' => $request->body,
            'type' => $type,
            'status' => 1,
        ]);

        Log::info('New content added', [
            'user' =>  Auth::user()->name,
            'title' =>  $request->title,
            'type' =>  $type,
            'body' =>  $request->body,
            'link' => ($type != 'photo') ? route("$type.show", [$content]) : '',
        ]);

        return redirect()
            ->route(''.$type.'.index')
            ->with('info', trans(
                'content.store.status.'
                .config("content_$type.store.status", 1)
                .'.info', [
                    'title' => $content->title,
                ]
            ));
    }

    public function edit($id)
    {
        $content = Content::findOrFail($id);

        return layout('2col')

            ->with('narrow', true)

            ->with('background', component('BackgroundMap'))
            ->with('color', 'gray')

            ->with('header', region('ForumHeader', collect()
                ->push(component('Title')
                    ->is('gray')
                    ->with('title', trans('content.forum.index.title'))
                    ->with('route', route('forum.index'))
                )
                ->push(component('BlockHorizontal')
                    ->with('content', region('ForumLinks'))
                )
            ))

            ->with('content', collect()
                ->push(component('Title')
                    ->with('title', trans('content.misc.edit.title'))
                )
                ->push(component('Form')
                    ->with('id', 'ForumCreateForm')
                    ->with('route', route('forum.update.misc', $content->id))
                    ->with('fields', collect()
                        ->push(component('FormHidden')
                            ->with('name', 'type')
                            ->with('value', $content->type)
                        )
                        ->push(component('FormTextfield')
                            ->is('large')
                            ->with('title', trans('content.forum.edit.field.title.title'))
                            ->with('name', 'title')
                            ->with('value', $content->title)
                        )
                        ->push(component('FormTextarea')
                            ->with('title', trans('content.forum.edit.field.body.title'))
                            ->with('name', 'body')
                            ->with('value', $content->body)
                            ->with('rows', 20)
                        )
                        ->push(component('FormButton')
                            ->is('hidden')
                            ->with('title', trans('content.create.submit.title'))
                        )
                        ->push(component('FormButtonProcess')
                            ->with('id', 'ForumCreateForm')
                            ->with('title', trans('content.edit.submit.title'))
                            ->with('processingtitle', trans('content.edit.submitting.title'))
                        )
                    )
                )
            )

            ->with('sidebar', collect()
                ->push(component('Block')
                    ->is('gray')
                    ->with('content', collect()
                        ->push(component('Title')
                            ->is('smaller')
                            ->is('red')
                            ->with('title', trans('content.misc.edit.notes.heading'))
                            ->with('route', route('forum.index'))
                        )
                        ->push(component('Body')
                            ->with('body', trans('content.misc.edit.notes.body'))
                        )
                    ))
            )

            ->with('footer', region('Footer'))

            ->render();
    }

    public function update(Request $request, $id)
    {
        $content = Content::find($id);

        $content->title = $request->title;
        $content->body = $request->body;
        $content->type = $request->type;
        $content->save();

        return redirect()
            ->route(''.$request->type.'.show', [$content->slug])
            ->with('info', trans('content.update.info', [
                'title' => $content->title,
            ]));
    }
}
