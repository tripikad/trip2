<?php

namespace App\Http\Regions;

class Filter
{
    public function render($destinations, $topics)
    {
        return component('Form')
                ->with('route', route('styleguide.form'))
                ->with('fields', collect()
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