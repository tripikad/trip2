<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class FormTextField extends Component
{
    public string $title;
    public string $name;
    public string $type;
    public ?string $value;
    public string $placeholder;
    public bool $disabled;
    public string $isclasses; //no need later

    /**
     * Create a new component instance.
     *
     * @param string $name
     * @param string $title
     * @param null $value
     * @param string $type
     * @param string $placeholder
     * @param bool $disabled
     */
    public function __construct(string $name, $title = '', $value = null, $type = 'text', $placeholder = '', $disabled = false, $isclasses = '')
    {
        $this->name = $name;
        $this->title = $title;
        $this->type = $type;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->disabled = $disabled;
        $this->isclasses = $isclasses;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.FormTextfield.FormTextfield');
    }
}
