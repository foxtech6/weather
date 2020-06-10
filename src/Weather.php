<?php

namespace Src;

use Src\Exceptions\ApiWeatherException;
use stdClass;
use Throwable;

class Weather
{
    private $city;
    private $weather;

    public function __construct(string $city)
    {
        $this->city = $city;
    }

    public function temperature(): float
    {
        try {
            return $this->getWeather()->main->temp;
        } catch (Throwable $e) {
            throw new ApiWeatherException();
        }
    }

    private function getWeather(): stdClass
    {
        if (!$this->weather) {
            $this->weather = (new CurlManager())->request(sprintf(
                '%s?%s',
                env('weather_url'),
                http_build_query(['q' => $this->city, 'appid' => env('weather_key')])
            ))->getResponse();
        }

        return json_decode($this->weather);
    }

}