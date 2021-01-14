<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class BodyBackgroundMap extends Component
{
    public string $svg = '#map';

    /**
     * Create a new component instance.
     *
     * @param string $svg
     */
    public function __construct($svg = '#map')
    {
        $this->svg = $svg;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.BodyBackgroundMap');
    }
}
