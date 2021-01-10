<div {{ $attributes->merge(['class' => 'VacationPackageListItem']) }}>
    <div class="VacationPackageListItem__image">
        <img src="{{$package->small_image}}" alt=""/>
    </div>
    <div class="VacationPackageListItem__content">
        <div class="VacationPackageListItem__tags">
            <x-tag
                title="{{trans('vacation_package.status.' . $package->status)}}"
                isclasses="{{$package->status === 'active' ? 'Tag--green' : ''}}"/>
        </div>
        <div class="VacationPackageListItem__title">
            <a href="{{route('vacation_package.show', ['slug' => $package->slug])}}">{{$package->name}}</a>
        </div>
        <div class="VacationPackageListItem__actions">
            @if ($package->canChangeStatus)
                <form action="{{ route('company.package.active', ['company' => $package->company, 'package' => $package]) }}" method="POST">
                    {{ csrf_field() }}
                    <input
                        type="submit"
                        value="{{$package->active ? 'Muuda mitteaktiivseks' : 'Muuda aktiivseks'}}"
                        class="VacationPackageListItem__btn {{$package->active ? 'inactive' : 'active'}}">
                </form>
            @endif
            <div class="VacationPackageListItem__btn edit">
                <a href="{{route('company.edit_package', ['company' => $package->company, 'package' => $package])}}">Muuda</a>
            </div>
            <div class="VacationPackageListItem__btn delete">Kustuta</div>
        </div>
    </div>
</div>