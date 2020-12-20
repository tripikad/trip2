<?php

namespace App\View\Components\Company;

use App\VacationPackage;
use Illuminate\View\Component;
use Illuminate\View\View;

class VacationPackageItem extends Component
{
    public VacationPackage $package;

    /**
     * Create a new component instance.
     *
     * @param VacationPackage $package
     */
    public function __construct(VacationPackage $package)
    {
        $this->package = $package;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.Company.VacationPackageItem');
    }
}
