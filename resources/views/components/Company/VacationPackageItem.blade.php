<div {{ $attributes->merge(['class' => 'CompanyVacationPackageItem']) }}>
    <div class="CompanyVacationPackageItem__image">
        <img src="{{$package->small_image}}" alt=""/>
    </div>
    <div class="CompanyVacationPackageItem__content">
        <div class="CompanyVacationPackageItem__content__tags">
            <x-vacation-package.status-tag
                    title="{{trans('vacation_package.status.' . $package->status)}}"
                    type="{{$package->status}}"/>
        </div>
        <div class="CompanyVacationPackageItem__content__title">
            <a href="#">{{$package->name}}</a>
        </div>
        <div class="CompanyVacationPackageItem__content__actions">
            @if ($package->canChangeStatus)
                <form action="{{ route('company.package.active', ['company' => $package->company, 'package' => $package]) }}" method="POST">
                    {{ csrf_field() }}
                    <input
                        type="submit"
                        value="{{$package->active ? 'Muuda mitteaktiivseks' : 'Muuda aktiivseks'}}"
                        class="CompanyVacationPackageItem__content__actions__btn {{$package->active ? 'inactive' : 'active'}}">
                </form>
            @endif
            <div class="CompanyVacationPackageItem__content__actions__btn edit">
                <a href="{{route('company.edit_package', ['company' => $package->company, 'package' => $package])}}">Muuda</a>
            </div>
            <div class="CompanyVacationPackageItem__content__actions__btn delete">Kustuta</div>
        </div>
    </div>
</div>