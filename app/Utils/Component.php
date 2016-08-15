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
        $this->with->push([$key => $value]);

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

    public function render()
    {
        if (! $this->show) {
            return '';
        }

        $name = "v2.components.$this->component.$this->component";

        $with = $this->with->flatten(1)->all();

        if (view()->exists($name)) {
            return View::make($name, $with)
                ->with('isclasses', $this->generateIsClasses())
                ->render();
        } else {
            $props = collect($with)->map(function ($value, $key) {
                $value = is_array($value) ? rawurlencode(json_encode($value)) : $value;

                return $key.'="'.$value.'"';
            })->implode(' ');

            return '<component is="'
                .$this->component
                .'" isclasses="'
                .$this->generateIsClasses()
                .'" '
                .$props
                .' />';
        }
    }

    public function __toString()
    {
        return $this->render();
    }
}
