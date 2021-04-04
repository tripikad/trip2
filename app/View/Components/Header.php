<?php

namespace App\View\Components;

use App\User;
use Illuminate\View\Component;
use Illuminate\View\View;

class Header extends Component
{
    private ?User $user;
    public string $navBarType;
    public string $backgroundImage;

    /**
     * Create a new component instance.
     *
     * @param string $navBarType
     * @param string $backgroundImage
     */
    public function __construct($backgroundImage = '/photos/header3.jpg', $navBarType = 'white')
    {
        $this->user = auth()->user();
        $this->navBarType = $navBarType;
        $this->backgroundImage = $backgroundImage;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.Header');
    }
}