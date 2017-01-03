<?php

namespace App;

use Exception;

class V2MessageVars
{
    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
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

    public function title()
    {
        return str_limit($this->attributes['body'], 30);
    }

    public function body()
    {
        return format_body($this->message->body);
    }

    public function created_at()
    {
        return format_date($this->message->created_at);
    }

    public function updated_at()
    {
        return format_date($this->message->created_at);
    }

}
