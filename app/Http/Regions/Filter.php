<?php

namespace App\Http\Regions;

class Filter
{
    public function render($destinations, $topics, $page = 1, $type = '')
    {
        return component('Form')
                ->with('route', route('utils.filter'))
                ->with('fields', collect()
                    ->push(component('FormHidden')->with('name', 'type')->with('value', $type))
                    ->push(component('FormHidden')->with('name', 'page')->with('value', $page))
                    ->pushWhen($destinations, component('FormSelect')
                        ->with('name', 'destination')
                        ->with('options', $destinations)
                        ->with('placeholder', trans('content.index.filter.field.destination.title'))
                        ->with('helper', 'Press E to select')
                        ->with('multiple', false)
                    )
                    ->pushWhen($topics, component('FormSelect')
                        ->with('name', 'topic')
                        ->with('options', $topics)
                        ->with('placeholder', trans('content.index.filter.field.topic.title'))
                        ->with('helper', 'Press E to select')
                        ->with('multiple', false)
                    )
                    ->push(component('FormButton')
                        ->with('title', trans('content.index.filter.submit.title'))
                    ));
    }
}
