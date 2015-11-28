@foreach(['contact_facebook', 'contact_twitter', 'contact_instagram', 'contact_homepage'] as $contact)

    @if($user->$contact)
    
        <a href="{{ $user->$contact }}" target="_blank">
        
            {{ trans("user.show.$contact.title") }}
    
        </a> 

    @endif

@endforeach