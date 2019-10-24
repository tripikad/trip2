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
    protected $vue;

    public function __construct($component)
    {
        $this->component = $component;
        $this->is = collect();
        $this->with = collect();
        $this->when = true;
        $this->vue = false;
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

    public function vue()
    {
        $this->vue = true;

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
       
        $name = "components.$this->component.$this->component";
        $bladeName = resource_path("views/components/$this->component/$this->component.blade.php");
        $vueName = resource_path("views/components/$this->component/$this->component.vue");
        
        if ($this->vue && is_file($vueName)) {
            return $this->renderVue($name);
        }
        if ($this->vue && !is_file($vueName)) {
            return '';
        }
        if (is_file($vueName) && is_file($bladeName)) {
            return $this->renderBlade($name);
        }
        if (!is_file($vueName) && is_file($bladeName)) {
            return $this->renderBlade($name);
        }
        if (is_file($vueName) && !is_file($bladeName)) {
            return $this->renderVue($name);
        }
        return '';
    }

    public function __toString()
    {
        return $this->render();
    }
}
