From {{ $user_from->name }}:

{!! $new_message->body !!}

{{ trans('message.store.email.body', [
    'url' => route('user.show.messages.with', [
        $user_to->id,
        $user_from->id,
        '#message-' . $new_message->id
    ])
]) }}

---

{{ config('site.name') }}