@php

$forum = $forum ?? '';
$comment = $comment ?? '';

@endphp

<div class="UserCommentBlock {{ $isclasses }}">

    <div class="UserCommentBlock__forum">

        {!! $forum !!}

    </div>

    <div class="UserCommentBlock__comment">

        {!! $comment !!}

    </div>

</div>
