{{ trans('follow.email.content.body', [
    'url' => route('content.show', [
        $comment->content->type,
        $comment->content,
        '#comment-' . $comment->id
    ])
]) }}
<br /><br />
--
<br />
{{ config('site.name') }}