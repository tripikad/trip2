@php

$forum = $forum ?? '';
$comment = $comment ?? '';

@endphp

<div class="UserCommentRow {{ $isclasses }}">

    <div class="UserCommentRow__forum">

        {!! $forum !!}

    </div>

    <div class="UserCommentRow__comment">

        {!! $comment !!}

    </div>

</div>
