<form {{ $attributes->merge(['class' => 'CompanyVacationPackageForm']) }}
      action="{{ route('company.update_profile', [$company]) }}"
      method="POST"
      autocomplete="off"
      enctype="multipart/form-data"
>
    {{ csrf_field() }}

    {{--User info--}}


    <div class="CompanyEditProfileForm__submit-button">
        <x-form.submit-button
                title="{{ trans('company.edit.submit') }}"/>
    </div>
</form>