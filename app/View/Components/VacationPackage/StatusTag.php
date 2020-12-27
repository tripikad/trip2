<?php

namespace App\View\Components\VacationPackage;

use Illuminate\View\Component;
use Illuminate\View\View;

class StatusTag extends Component
{
    public string $title;
    public string $type;

    /**
     * Create a new component instance.
     *
     * @param string $title
     * @param string $type
     */
    public function __construct(string $title, string $type = '')
    {
        $this->title = $title;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.VacationPackage.StatusTag');
    }
}
