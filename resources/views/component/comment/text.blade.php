<ul class="component-text list-inline">

    <li>
    
        {!! view('component.user.link', ['user' => $comment->user]) !!}

    </li>

    <li>

        <a
            class="permalink"
            href="#comment-{{ $comment->id }}"
            alt="{{ $comment->created_at }}"
        >
            {{ $comment->created_at->diffForHumans() }}

        </a>

    </li>

</ul>