<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Ads extends Component
{
    public string $id;

    /**
     * Create a new component instance.
     *
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.Ads');
    }
}
