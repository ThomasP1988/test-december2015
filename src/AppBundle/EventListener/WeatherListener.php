<?php
namespace AppBundle\EventListener;

use Symfony\Component\EventDispatcher\Event;

class WeatherListener {

//    private $awsSns;
//
//    public function __construct($awsSns) {
//        $this->awsSns = $awsSns;
//    }

    private $logger;

    public function __construct($logger) {
        $this->logger = $logger;
    }

    public function onTemperatureChange(Event $event)
    {
        $message = array(
            'Message' => $event->getMessage(),
            'Subject' => 'Temperature change',
        );
//        $this->awsSns->publish($message);
        $this->logger->info($event->getMessage());
    }

    public function onConditionChange(Event $event)
    {
        $message = array(
            'Message' => $event->getMessage(),
            'Subject' => 'Condition change',
        );
//        $this->awsSns->publish($message);
        $this->logger->info($event->getMessage());
    }
}