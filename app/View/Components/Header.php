<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Header extends Component
{
    private $user;
    public string $type;
    public string $navBarType;

    /**
     * Create a new component instance.
     *
     * @param string $type
     * @param string $navBarType
     */
    public function __construct($type = 'main', $navBarType = 'white')
    {
        $this->user = auth()->user();
        $this->type = $type;
        $this->navBarType = $navBarType;
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
