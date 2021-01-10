<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Tag extends Component
{
    public string $title;
    public ?string $route;
    public string $isclasses;

    /**
     * Create a new component instance.
     *
     * @param $title
     * @param string $isclasses
     * @param string|null $route
     */
    public function __construct($title, $isclasses = '', $route = null)
    {
        $this->title = $title;
        $this->isclasses = $isclasses;
        $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.Tag.Tag');
    }
}
