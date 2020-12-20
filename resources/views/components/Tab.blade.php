<li {{ $attributes->merge(['class' => 'Tabs__tab' . ($active ? ' Tabs__tab--active' : '')]) }}>
    <a href="{{$route}}">
        {{$title}}
        @if(isset($count))
            <span class="Tabs__tab__count">{{$count}}</span>
        @endif
    </a>
</li>