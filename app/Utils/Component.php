<?php

namespace App\Utils;

use View;
use InvalidArgumentException;

class Component
{
    protected $component;
    protected $is;
    protected $with;
    protected $when;

    public function __construct($component)
    {
        $this->component = $component;
        $this->is = collect();
        $this->with = collect();
        $this->when = true;
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

    public function when($condition)
    {
        $this->when = $condition;

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
            ->map(function($value, $key) {
                $value = json_encode($value, JSON_HEX_APOS);
                return ":$key='$value'";
            })
            ->implode(' ');

        return '<component is="'
            .$this->component
            .'" isclasses="'
            .$this->generateIsClasses()
            .'" '
            .$props
            .' ></component>';
    }

    public function render()
    {
        if (! $this->when) {
            return '';
        }

        $name = "v2.components.$this->component.$this->component";
        $file_name = $this->exists($name);
        $path_info = pathinfo($file_name);

        if ($file_name !== false && $path_info['extension'] != 'css') {
            return $this->renderBlade($name);
        } else {
            return $this->renderVue($name);
        }
    }

    public function exists($view)
    {
        try {
            return view()->getFinder()->find($view);
        } catch (InvalidArgumentException $e) {
            return false;
        }
    }

    public function __toString()
    {
        return $this->render();
    }
}
