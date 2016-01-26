    <div class="c-row">

        <a class="c-profile" href="{{ route('user.show', [$user]) }}">

        <img src="{{ $user->imagePreset() }}" alt="" class="c-profile__image">&nbsp;&nbsp;{{ $user['name'] }}

		</a>

    </div>