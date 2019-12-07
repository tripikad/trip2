<?php

namespace App;

use Lang;
use Exception;

class DestinationVars
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

        throw new Exception(sprintf($message, static::class, $property));
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
        return format_body($this->destination->description);
    }

    // @TODO2 Refactor this

    public function countries()
    {
        if ($this->destination->isContinent()) {
            return $this->destination->getImmediateDescendants();
        }

        return false;
    }

    // @TODO2 Refactor this

    public function country()
    {
        if ($this->destination->isCity() || $this->destination->isPlace()) {
            return $this->destination
        ->getAncestors()
        ->filter(function ($d) {
            return $d->isCountry();
        })
        ->first();
        }

        return false;
    }

    public function facts()
    {
        if ($facts = config("facts.{$this->destination->id}")) {
            return (object) $facts;
        }
    }

    public function coordinates()
    {
        if ($this->facts() && $this->facts()->lat && $this->facts()->lon) {
            return ['lat' => $this->facts()->lat, 'lon' => $this->facts()->lon];
        }
        return null;
    }

    public function snappedCoordinates()
    {
        if ($this->facts() && $this->facts()->lat && $this->facts()->lon) {
            return [
        'lat' => snap($this->facts()->lat, 2.5),
        'lon' => snap($this->facts()->lon, 2.5)
      ];
        }
        return null;
    }

    public function area()
    {
        if ($facts = $this->facts()) {
            if ($facts->area > 1000) {
                return number_format(round($facts->area, -3), 0, ',', ' ') . ' km²';
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
        if (!$this->destination->isContinent() && ($facts = $this->facts())) {
            return '+' . $facts->calling_code;
        }
    }

    public function currencyCode()
    {
        if ($facts = $this->facts()) {
            return $facts->currency_code;
        }
    }

    public function timezone()
    {
        if ($facts = $this->facts()) {
            if ($facts->timezone && $facts->timezone > 0) {
                return 'GMT + ' . $facts->timezone;
            }
            if ($facts->timezone && $facts->timezone == 0) {
                return 'GMT';
            }
            if ($facts->timezone && $facts->timezone < 0) {
                return 'GMT ' . $facts->timezone;
            }
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
