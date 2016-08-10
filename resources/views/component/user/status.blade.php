<div class="c-user-status">

    @if(isset($status))

        @if(isset($editor) && $editor)

            @include('component.tooltip', [
                'modifiers' => 'm-one-line m-top m-center '. $modifiers,
                'text' => trans('user.rank.'.$status).' / ' .trans('user.role.editor')
            ])

        @else

            @include('component.tooltip', [
                'modifiers' => 'm-one-line m-top m-center '. $modifiers,
                'text' => trans('user.rank.'.$status)
            ])

        @endif

    @endif

</div>