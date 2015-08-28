<ul class="list-inline text-center">

    <li>
        <a href="{{ route('user.show', [$user]) }}">
            {{ trans('user.show.menu.activity') }}
        </a>
    </li>
    
    <li>
        <a href="{{ route('user.show.messages', [$user]) }}">
            {{ trans('user.show.menu.messages') }}
        </a>
    </li>
    
    <li>
        <a href="{{ route('user.show.follows', [$user]) }}">
            {{ trans('user.show.menu.follows') }}
        </a>
    </li>

</ul>