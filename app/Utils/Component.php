<?php

namespace App\Utils;

use View;

class Component
{
    protected $component;
    protected $is;
    protected $with;
    protected $show;

    public function __construct($component)
    {
        $this->component = $component;
        $this->is = collect();
        $this->with = collect();
        $this->show = true;
    }

    public function is($is)
    {
        $this->is->push($is);

        return $this;
    }

    public function with($key, $value)
    {
        $this->with->put($key, $value);

        return $this;
    }

    public function show($condition)
    {
        $this->show = $condition;

        return $this;
    }

    public function generateIsClasses()
    {
        $component = $this->component;

        if (! $this->is->isEmpty()) {
            return $this->is->map(function ($item) use ($component) {
                return $component.'--'.$item;
            })
            ->implode(' ');
        }

        return '';
    }

    public function renderBlade($name)
    {
        return View::make($name, $this->with)
            ->with('isclasses', $this->generateIsClasses())
            ->render();
    }

    public function renderVue($name)
    {
        $props = $this->with
            ->map(function ($value, $key) {
                if (is_array($value) || is_object($value) || is_bool($value)) {
                    $value = rawurlencode(json_encode($value));
                }

                return $value;
            })
            ->map(function ($value, $key) {
                return $key.'="'.$value.'"';
            })
            ->implode(' ');

        return '<component is="'
            .$this->component
            .'" isclasses="'
            .$this->generateIsClasses()
            .'" '
            .$props
            .' />';
    }

    public function renderVue2($name)
    {
        return '<component is="Test"></component>';
    }

    public function render()
    {
        if (! $this->show) {
            return '';
        }

        $name = "v2.components.$this->component.$this->component";

        if (view()->exists($name)) {
            return $this->renderBlade($name);
        } else {
            return $this->renderVue($name);
        }
    }

    public function __toString()
    {
        return $this->render();
    }
}
