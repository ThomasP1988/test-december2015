<?php
namespace AppBundle\Event;

use Symfony\Component\EventDispatcher\Event;

class WeatherEvent extends Event
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }
}