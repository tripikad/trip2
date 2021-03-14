<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class FormSubmitButton extends Component
{
    public string $title;

    /**
     * Create a new component instance.
     *
     * @param string $title
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.FormSubmitButton.FormSubmitButton');
    }
}
