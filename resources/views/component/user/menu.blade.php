<ul class="list-inline text-center">

    <li>
        <a href="{{ route('user.show', [$user]) }}">
            {{ trans('user.show.menu.activity') }}
        </a>
    </li>
    
    <li>
        <a href="{{ route('message.index', [$user]) }}">
            {{ trans('user.show.menu.messages') }}
        </a>
    </li>
    
    <li>
        <a href="{{ route('follow.index', [$user]) }}">
            {{ trans('user.show.menu.follow') }}
        </a>
    </li>

</ul>