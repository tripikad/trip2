<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;
use Illuminate\View\View;

class TextField extends Component
{
    public string $label;
    public string $name;
    public string $type;
    public ?string $value;
    public string $placeholder;
    public bool $disabled = false;

    /**
     * Create a new component instance.
     *
     * @param $label
     * @param $name
     * @param string $type
     * @param string|null $value
     * @param string $placeholder
     */
    public function __construct($label, $name, $type = 'text', $value = null, $placeholder = '')
    {
        $this->label = $label;
        $this->name = $name;
        $this->type = $type;
        $this->value = $value;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.Form.TextField');
    }
}
