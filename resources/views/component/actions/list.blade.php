@if (isset($actions) && count($actions))
    @foreach($actions as $action)
        <li class="c-inline-list__item">
            {!! Form::open([
            'url' => $action['route'],
            'method' => isset($action['method']) ? $action['method'] : 'GET',
            'class' => 'c-actions__form m-inline'
            ]) !!}
            {!! Form::submit($action['title'], [
            'class' => 'c-inline-list__item-link'
            ]) !!}
            {!! Form::close() !!}
        </li>
    @endforeach
@endif

@if (isset($items) && count($items))
    @foreach ($items as $item)
        @if($item['title'])
            <li class="c-inline-list__item">
                @if(isset($item['route']))
                    <a href="{{ $item['route'] }}" class="c-inline-list__item-link">{!! $item['title'] !!}</a>
                @else
                    {!! $item['title'] !!}
                @endif
            </li>
        @endif
    @endforeach
@endif
