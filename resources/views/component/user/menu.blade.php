<ul class="list-inline text-center">

    <li>
        <a href="{{ route('user.show', [$user]) }}">
            {{ trans('user.show.menu.activity') }}
        </a>
    </li>
    
    <li>
        <a href="{{ route('message.index', [$user]) }}">
            {{ trans('user.show.menu.message') }}
        </a>
    </li>
    
    <li>
        <a href="{{ route('user.show.follows', [$user]) }}">
            {{ trans('user.show.menu.follows') }}
        </a>
    </li>

</ul>