@component('mail::message')
# {{ trans('message.store.email.body') }}

@component('mail::button', ['url' => route('message.index.with', [$user_to->id, $user_from->id, '#message-' . $new_message->id]), 'color' => 'green'])
{{ trans('message.store.email.button.text') }}
@endcomponent

@endcomponent
