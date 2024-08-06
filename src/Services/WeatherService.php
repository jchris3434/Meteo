<?php

namespace Services;

/**
 * Class WeatherService
 *
 * Open Weather Api doc : https://openweathermap.org/api
 *
 * @package PhpTest
 */
class WeatherService
{
    /**
     * @var string
     */
    private string $apiKey;

    /**
     * @var string
     */
    private string $apiUrl;

    /**
     * WeatherService constructor.
     * @param string $apiKey
     * @param string $apiUrl
     */
    public function __construct(string $apiKey = OPENWEATHER_API_KEY, string $apiUrl = 'https://api.openweathermap.org/data/2.5/')
    {
        $this->apiKey = $apiKey;
        $this->apiUrl = $apiUrl;
    }

    /**
     * Get weather by city name.
     *
     * @param string $cityName
     * @return mixed
     */
    public function getWeatherByCityName(string $cityName)
    {
        $url = $this->apiUrl . "weather?q={$cityName}&APPID={$this->apiKey}&units=metric";
        return $this->makeRequest($url);
    }

    /**
     * Get weather by city ID.
     *
     * @param int $cityId
     * @return mixed
     */
    public function getWeatherByCityId(int $cityId)
    {
        $url = $this->apiUrl . "weather?id={$cityId}&APPID={$this->apiKey}&units=metric";
        return $this->makeRequest($url);
    }

    /**
     * Get weather by geographic coordinates.
     *
     * @param float $lat
     * @param float $lon
     * @return mixed
     */
    public function getWeatherByCoordinates(float $lat, float $lon)
    {
        $url = $this->apiUrl . "weather?lat={$lat}&lon={$lon}&APPID={$this->apiKey}&units=metric";
        return $this->makeRequest($url);
    }

    /**
     * Make an HTTP request to the API.
     *
     * @param string $url
     * @return mixed
     */
    public function makeRequest(string $url): ?float
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new \Exception(curl_error($ch));
        }
        curl_close($ch);
        $data = json_decode($response, true);

        // on cible juste la temp
        return $data['main']['temp'] ?? null;
    }

}