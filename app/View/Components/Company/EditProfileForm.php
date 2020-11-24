<?php

namespace App\View\Components\Company;

use App\Company;
use App\User;
use Illuminate\View\Component;
use Illuminate\View\View;

class EditProfileForm extends Component
{
    public Company $company;
    public User $user;

    public function __construct(Company $company, User $user)
    {
        $this->company = $company;
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.Company.EditProfileForm');
    }
}
