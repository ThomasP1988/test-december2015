<?php

namespace AppBundle\Services;

use AppBundle\Entity\Condition;

class YahooWeathAPI {

    const BASE_URL = 'http://query.yahooapis.com/v1/public/yql';

    public function requestWeather($city) {
        $yql_query =
            'select location, item.condition from weather.forecast where woeid in (select woeid from geo.places(1) where text="'.$city.'")';
        $yql_query_url = self::BASE_URL . "?q=" . urlencode($yql_query) . "&format=json";

        $session = curl_init($yql_query_url);
        curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
        $json = curl_exec($session);

        $phpObj =  json_decode($json);
        $condition = $phpObj->query->results->channel->item->condition;
        $location = $phpObj->query->results->channel->location;

        $currentCondition = new Condition($location->city, $location->country, $phpObj->query->created, $condition->date, $condition->temp, $condition->text);

        return $currentCondition;
    }

}