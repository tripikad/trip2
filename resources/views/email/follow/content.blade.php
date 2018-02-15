@component('mail::message')
# {{ trans('follow.email.content.body') }}

@component('mail::button', ['url' => route('content.show', [$comment->content->type, $comment->content, '#comment-' . $comment->id]), 'color' => 'green'])
{{ trans('follow.email.button.text') }}
@endcomponent

@endcomponent
