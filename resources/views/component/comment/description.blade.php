<ul class="component-comment-description list-inline">

    <li>
    
        {!! view('component.user.link', ['user' => $comment->user]) !!}

    </li>

    <li>

        <a
            class="permalink"
            href="#comment-{{ $comment->id }}"
            alt="{{ $comment->created_at }}"
        >
            {{ view('component.date.relative', ['date' => $comment->created_at]) }}

        </a>

    </li>

</ul>