<ul class="component-content-description list-inline">

    <li>
    
        {!! view('component.user.link', ['user' => $content->user]) !!}

    </li>

    </li>

        {{ view('component.date.relative', ['date' => $content->created_at]) }}

    </li>

@if (count($content->comments))

    <li>

        {{ trans('content.row.text.comment', [
            'updated_at' => view('component.date.relative', ['date' => $content->updated_at])
        ]) }}
    
    <li>

@endif

@if (count($content->destinations))

    <li>

        {!! $content->destinations->implode('name', '</li><li>') !!}

    </li>

@endif

@if (count($content->topics))

    <li>

        {!! $content->topics->implode('name', '</li><li>') !!}

    </li>

@endif

</ul>