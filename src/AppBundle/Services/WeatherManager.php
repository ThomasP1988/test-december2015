<?php

namespace AppBundle\Services;

use AppBundle\Entity\Condition;
use AppBundle\Event\WeatherEvent;

class WeatherManager {

    private $currentCondition;
    private $previousCondition;
    private $cacheProvider;
    private $eventDispatcher;

    public function __construct($cacheProvider, $eventDispatcher) {
        $this->cacheProvider = $cacheProvider;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @return mixed
     */
    public function getCurrentCondition()
    {
        return $this->currentCondition;
    }

    /**
     * @param mixed $currentCondition
     */
    public function setCurrentCondition($currentCondition)
    {
        $this->currentCondition = $currentCondition;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPreviousCondition()
    {
        return $this->previousCondition;
    }

    /**
     * @param mixed $previousCondition
     */
    public function setPreviousCondition($previousCondition = null)
    {
        if($previousCondition) {
            $this->previousCondition = $previousCondition;
        } else {
            $locationKey = preg_replace('/\s+/', '', $this->currentCondition->getCity().$this->currentCondition->getCountry());
            $this->previousCondition = unserialize($this->cacheProvider->fetch($locationKey));
            $this->cacheProvider->save($locationKey, serialize($this->currentCondition));
        }
        return $this;
    }

    public function hasPreviousCondition() {
        return !empty($this->previousCondition);
    }

    public function compare() {
        $this->compareTemperature();
        $this->compareDescription();
    }

    public function compareTemperature() {
        if($this->currentCondition->getTemperature() !== $this->previousCondition->getTemperature()) {
            $difference = $this->currentCondition->getTemperature() - $this->previousCondition->getTemperature();
            $word = $difference > 0 ? 'risen' : 'fallen';
            $message = 'temperature has '.$word.' from '.$this->previousCondition->getTemperature().' to '. $this->currentCondition->getTemperature();
            $event = new WeatherEvent($message);
            $this->eventDispatcher->dispatch('temperature.changed', $event);
        }
    }

    public function compareDescription() {
        if($this->currentCondition->getDescription() !== $this->previousCondition->getDescription()) {
            $message = 'condition has changed from '.$this->previousCondition->getDescription().' to '. $this->currentCondition->getDescription();
            $event = new WeatherEvent($message);
            $this->eventDispatcher->dispatch('condition.changed', $event);
        }
    }

    public function test() {
        $this->currentCondition->setTemperature(200);
        $this->currentCondition->setDescription('cyclon');
        return $this;
    }
}