<?php

namespace App\View\Components\VacationPackage;

use App\Company;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;
use Illuminate\View\View;

class PackageList extends Component
{
    public Collection $packages;
    public Company $company;

    public function __construct(Company $company)
    {
        $this->packages = $company->vacationPackages()->get();
        $this->company = $company;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        $canActivateMore = $this->company->canActivateVacationPackage();
        $activePackages = $draftPackages = $expiredPackages = [];
        foreach ($this->packages as $package) {
            $package->canChangeStatus = false;
            if ($package->end_date < Carbon::today()->toDateString()) {
                $expiredPackages[] = $package;
            } else if ($package->active === true) {
                $activePackages[] = $package;
                $package->canChangeStatus = true;
            } else {
                $package->canChangeStatus = $canActivateMore;
                $draftPackages[] = $package;
            }
        }

        return view('components.VacationPackage.PackageList', [
            'activePackages' => $activePackages,
            'draftPackages' => $draftPackages,
            'expiredPackages' => $expiredPackages
        ]);
    }
}
