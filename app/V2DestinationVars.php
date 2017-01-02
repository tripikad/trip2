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
        $config = config("destinations.{$this->destination->id}");

        return $config ? collect(config("destinations.{$this->destination->id}")) : null;
    }

    public function isContinent()
    {   
        return $this->destination->isRoot();
    }

    public function isCountry()
    {   
        return $this->destination->getLevel() == 1;
    }

    public function getCountry()
    {   
        $level = $this->destination->getLevel();
        
        if ($level > 1) {
            return $this->destination->getAncestors()[1];
        }
        
        if ($level == 1) {
            return $this->destination;
        }
        
        return false;
    }
}
