<?php

namespace AppBundle\Entity;

class Condition {

    private $city;
    private $country;
    private $created;
    private $date;
    private $temperature;
    private $description;

    function __construct($city, $country, $created, $date, $temperature, $description)
    {
        $this->city = $city;
        $this->country = $country;
        $this->created = $created;
        $this->date = $date;
        $this->temperature = $temperature;
        $this->description = $description;
    }


    function __toString()
    {
        return $this->city . ', ' . $this->country . ': ' . $this->temperature . '°F, ' . $this->description
        . ' (' . $this->date . ')';
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }


    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getTemperature()
    {
        return $this->temperature;
    }

    /**
     * @param mixed $temperature
     */
    public function setTemperature($temperature)
    {
        $this->temperature = $temperature;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
}