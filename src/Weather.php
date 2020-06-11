<?php

namespace Src;

use Src\Exceptions\ApiWeatherException;
use stdClass;
use Throwable;

/**
 * Class Weather
 *
 * @author Mykhailo Bavdys <bavdysmyh@ukr.net>
 * @since 10.06.2020
 */
class Weather
{
    /**
     * Request instance
     *
     * @var RequestInterface
     */
    private $curl;

    /**
     * Search weather for this city
     *
     * @var string
     */
    private $city;

    /**
     * Weather info
     *
     * @var string
     */
    private $weather;

    /**
     * Weather constructor
     *
     * @param RequestInterface $curl Request instance
     * @param string           $city Search weather for this city
     */
    public function __construct(RequestInterface $curl, string $city)
    {
        $this->city = $city;
        $this->curl = $curl;
    }

    /**
     * Get temperature from weather
     *
     * @return float
     *
     * @throws ApiWeatherException
     */
    public function temperature(): float
    {
        try {
            return $this->getWeather()->main->temp;
        } catch (Throwable $e) {
            throw new ApiWeatherException();
        }
    }

    /**
     * Get weather from api
     *
     * @return stdClass
     */
    private function getWeather(): stdClass
    {
        if (!$this->weather) {
            $this->weather = $this->curl->send(sprintf(
                '%s?%s',
                env('weather_url'),
                http_build_query(['q' => $this->city, 'appid' => env('weather_key')])
            ))->getResponse();
        }

        return json_decode($this->weather);
    }
}
