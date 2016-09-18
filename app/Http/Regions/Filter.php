<?php

namespace App\Http\Regions;

class Filter
{
    public function render($destinations, $topics, $currentDestination = null, $currentTopic = null, $currentPage = 1, $type = '')
    {
        return component('Form')
                ->with('route', route('utils.filter'))
                ->with('fields', collect()
                    ->push(component('FormHidden')->with('name', 'type')->with('value', $type))
                    ->push(component('FormHidden')->with('name', 'page')->with('value', $currentPage))
                    ->pushWhen($destinations, component('FormSelect')
                        ->with('name', 'destination')
                        ->with('options', $destinations)
                        ->with('placeholder', trans('content.index.filter.field.destination.title'))
                        ->with('multiple', false)
                        ->with('searchable', false)
                        ->with('value', $currentDestination)
                    )
                    ->pushWhen($topics, component('FormSelect')
                        ->with('name', 'topic')
                        ->with('options', $topics)
                        ->with('placeholder', trans('content.index.filter.field.topic.title'))
                        ->with('multiple', false)
                        ->with('searchable', false)
                        ->with('value', $currentTopic)
                    )
                    ->push(component('FormButton')
                        ->with('title', trans('content.index.filter.submit.title'))
                    ));
    }
}
