<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Tabs extends Component
{
    public array $tabs;

    /**
     * Create a new component instance.
     *
     * @param array $tabs
     */
    public function __construct(array $tabs)
    {
        $this->tabs = $tabs;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.Tabs.Tabs');
    }
}
