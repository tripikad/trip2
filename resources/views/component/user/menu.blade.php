<ul class="list-inline text-center">

    <li>
        <a href="{{ route('user.show', [$user]) }}">
            {{ trans('user.show.menu.activity') }}
        </a>
    </li>
    
    <li>
        <a href="{{ route('message.index', [$user]) }}">
<<<<<<< HEAD
            {{ trans('user.show.menu.messages') }}
=======
            {{ trans('user.show.menu.message') }}
>>>>>>> master
        </a>
    </li>
    
    <li>
        <a href="{{ route('follow.index', [$user]) }}">
            {{ trans('user.show.menu.follow') }}
        </a>
    </li>

</ul>