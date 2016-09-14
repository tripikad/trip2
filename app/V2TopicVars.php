<?php

namespace App;

use Exception;

class V2TopicVars
{
    protected $topic;

    public function __construct(Topic $topic)
    {
        $this->topic = $topic;
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
        return $this->topic->name;
    }

    public function shortName()
    {
        return str_limit($this->topic->name, 12);
    }

}
