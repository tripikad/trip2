<?php

namespace App;

use Lang;
use Exception;

class V2DestinationVars
{
    protected $destination;

    public function __construct(Destination $destination)
    {
        $this->destination = $destination;
    }

    public function __get($property)
    {
        if (method_exists($this, $property)) {
            return call_user_func([$this, $property]);
        }

        $message = '%s does not respond to the "%s" property or method.';

        throw new Exception(
            sprintf($message, static::class, $property)
        );
    }

    public function name()
    {
        return $this->destination->name;
    }

    public function shortName()
    {
        return str_limit($this->destination->name, 10);
    }

    public function description()
    {
        $key = "destination.show.description.{$this->destination->id}";

        return Lang::has($key) ? trans($key) : null;
    }

    public function facts()
    {
        if ($this->isContinent()) {
            return false;
        }

        if ($this->isCountry()) {
            $facts = config("destinations.{$this->destination->id}");

            if ($facts) {
                return collect($facts)
                    ->filter(function ($value, $key) {
                        return $key != 'code' && $key != 'capital';
                    })
                    ->map(function ($value, $key) {
                        if ($key == 'area') {
                            return number_format(round($value, -3), 0, ',', ' ');
                        }
                        if ($key == 'population') {
                            return number_format(round($value, -3), 0, ',', ' ');
                        }
                        if ($key == 'callingCode') {
                            return '+'.$value;
                        }

                        return $value;
                    });
            }
        }

        if ($this->isPlace()) {
            $facts = config("destinations.{$this->getCountry()->id}");

            if ($facts) {
                return collect($facts)
                    ->filter(function ($value, $key) {
                        return $key == 'callingCode' || $key == 'currencyCode';
                    })
                    ->map(function ($value, $key) {
                        if ($key == 'callingCode') {
                            return '+'.$value;
                        }

                        return $value;
                    });
            }
        }

        return false;
    }

    public function isContinent()
    {
        return $this->destination->isRoot();
    }

    public function isCountry()
    {
        return $this->destination->getLevel() == 1;
    }

    public function isPlace()
    {
        return $this->destination->getLevel() > 1;
    }

    public function getCountry()
    {
        if ($this->destination->getLevel() > 1) {
            return $this->destination->getAncestors()[1];
        }

        return false;
    }

    public function usersHaveBeen()
    {
        return $this->destination->flags->where('flag_type', 'havebeen');
    }

    public function usersWantsToGo()
    {
        return $this->destination->flags->where('flag_type', 'wantstogo');
    }
}
