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
        return str_limit($this->destination->name, 17);
    }

    public function description()
    {
        $key = "destination.show.description.{$this->destination->id}";

        return Lang::has($key) ? trans($key) : null;
    }

    public function isContinent()
    {
        return $this->destination->depth == 0;
    }

    public function isCountry()
    {
        return $this->destination->depth == 1;
    }

    public function isPlace()
    {
        return $this->destination->depth > 1;
    }

    public function getCountry()
    {
        if ($this->destination->depth > 1) {
            return $this->destination->getAncestors()[1];
        }

        return false;
    }

    public function facts()
    {
        if ($this->isCountry() && $facts = config("destinations.{$this->destination->id}")) {
            return (object) $facts;
        }

        if ($this->isPlace() && $facts = config("destinations.{$this->getCountry()->id}")) {
            return (object) $facts;
        }
    }

    public function area()
    {
        if ($facts = $this->facts()) {
            if ($facts->area > 1000) {
                return number_format(round($facts->area, -3), 0, ',', ' ').' km²';
            } else {
                return $facts->area;
            }
        }
    }

    public function population()
    {
        if ($facts = $this->facts()) {
            return number_format(round($facts->population, -3), 0, ',', ' ');
        }
    }

    public function callingCode()
    {
        if ($facts = $this->facts()) {
            return '+'.$facts->callingCode;
        }
    }

    public function currencyCode()
    {
        if ($facts = $this->facts()) {
            return $facts->currencyCode;
        }
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
