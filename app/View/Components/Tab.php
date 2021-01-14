<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Tab extends Component
{
    public string $title;
    public string $route;
    public bool $active;
    public ?int $count;

    /**
     * Create a new component instance.
     *
     * @param string $title
     * @param string $route
     * @param bool $active
     * @param int|null $count
     */
    public function __construct(string $title, string $route, $active = false, $count = null)
    {
        $this->title = $title;
        $this->route = $route;
        $this->active = $active;
        $this->count = $count;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View|string
     */
    public function render()
    {
        return view('components.Tabs.Tab');
    }
}
