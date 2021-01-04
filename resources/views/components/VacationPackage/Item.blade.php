<div {{ $attributes->merge(['class' => 'VacationPackageItem']) }}>
    <div class="VacationPackageItem__image">
        <img src="{{$package->medium_image}}" alt=""/>
        <span class="VacationPackageItem__image__price">al. {{$package->price}}€</span>
    </div>
    <div class="VacationPackageItem__meta">
        <div class="VacationPackageItem__meta__category">
            {{$package->getVacationPackageCategoryNames()}}
        </div>
        <div class="VacationPackageItem__meta__name">
            <a href="#">{{$package->name}}</a>
        </div>
        <div class="VacationPackageItem__meta__company">
            <div class="VacationPackageItem__meta__company__logo">
                <a href="{{route('company.page', ['slug' => $package->company->slug])}}">
                    <img src="{{$package->company->user->imagePreset()}}" alt=""/>
                </a>
            </div>
            <div class="VacationPackageItem__meta__company__name">
                <a href="{{route('company.page', ['slug' => $package->company->slug])}}">{{$package->company->name}}</a>
            </div>
        </div>
    </div>
</div>