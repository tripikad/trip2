<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;
use Illuminate\View\View;

class Textarea extends Component
{
    public string $label;
    public string $name;
    public int $rows;
    public ?string $value;
    public string $placeholder;

    public function __construct($label, $name, $rows = 6, $value = null, $placeholder = '')
    {
        $this->label = $label;
        $this->name = $name;
        $this->rows = $rows;
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
        return view('components.Form.Textarea');
    }
}
