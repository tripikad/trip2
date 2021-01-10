<div {{ $attributes->merge(['class' => 'VacationPackageGridItem']) }}>
    <div class="VacationPackageGridItem__image">
        <img src="{{$package->medium_image}}" alt=""/>
        <span class="VacationPackageGridItem__price">al. {{$package->price}}€</span>
    </div>
    <div class="VacationPackageGridItem__content">
        <div class="VacationPackageGridItem__category">
            {{$package->getVacationPackageCategoryNames()}}
        </div>
        <div class="VacationPackageGridItem__title">
            <a href="{{route('vacation_package.show', ['slug' => $package->slug])}}">{{$package->name}}</a>
        </div>
        <div class="VacationPackageGridItem__company">
            <div class="VacationPackageGridItem__company__logo">
                <a href="{{route('company.page', ['slug' => $package->company->slug])}}">
                    <img src="{{$package->company->user->imagePreset()}}" alt=""/>
                </a>
            </div>
            <div class="VacationPackageGridItem__company__name">
                <a href="{{route('company.page', ['slug' => $package->company->slug])}}">{{$package->company->name}}</a>
            </div>
        </div>
    </div>
</div>