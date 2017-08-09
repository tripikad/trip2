<?php

namespace App\Http\Controllers;

use Request;
use App\Destination;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return layout('2col')->with('background', component('BackgroundMap'))->render();
    }

    public function create()
    {
        $destinations = Destination::select('id', 'name')->orderBy('name', 'asc')->get();

        return layout('1col')
            ->with('background', component('BackgroundMap'))
                ->with('color', 'gray')

                ->with('header', region('Header', collect()
                    ->push(component('Title')
                        ->is('white')
                        ->with('title', trans('content.poll.index.title'))
                        ->with('route', route('poll.index'))
                    )
                ))
            ->with('content', collect()
                ->push(component('Title')
                    ->with('title', trans('content.poll.create.title'))
                )
                ->push(component('Form')
                    ->with('route', route('poll.store'))
                    ->with('fields', collect()
                        /*->push(component('FormRadio')
                            ->is('large')
                            ->with('name', 'poll_type')
                            ->with('value', old('type', 'poll'))
                            ->with('options', [
                                ['id' => 'poll', 'name' => 'Küsitlus'],
                                ['id' => 'qiuz', 'name' => 'Viktoriin']
                            ])
                        )*/
                        ->push(component('FormTextfield')
                            ->with('title', trans('content.poll.edit.field.start.title'))
                            ->with('name', 'start')
                            ->with('value', old('start'))
                        )
                        ->push(component('FormTextfield')
                            ->with('title', trans('content.poll.edit.field.end.title'))
                            ->with('name', 'end')
                            ->with('value', old('end'))
                        )
                        ->push(component('FormSelectMultiple')
                            ->with('name', 'destinations')
                            ->with('options', $destinations)
                            ->with('placeholder', trans('content.index.filter.field.destination.title'))
                        )
                        ->push(component('Title')
                            ->is('small')
                            ->with('title', trans('content.poll.edit.add.field.title'))
                        )
                        ->push(component('PollAddFields')
                            ->with('value', old('poll_type', 'poll'))
                        )
                        ->push(component('FormButton')
                            ->with('title', trans('content.create.submit.title'))
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
                            ->with('title', trans('content.edit.notes.heading'))
                            ->with('route', route('forum.index'))
                        )
                        ->push(component('Body')
                            ->with('body', trans('content.edit.notes.body'))
                        )
                ))
            )
            ->with('footer', region('Footer'))
            ->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
