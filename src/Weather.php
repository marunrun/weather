<?php

namespace Run6\Weather;

use GuzzleHttp\Client;
use Run6\Weather\Exception\HttpException;
use Run6\Weather\Exception\InvalidArgumentException;

class Weather
{
    protected $key; // APIkey

    protected $guzzleOptions = []; // guzzle的配置

    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @param $city
     * @param string $type
     * @param string $format
     *
     * @return false|string
     *
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function getWeather($city, $type = 'base', $format = 'json')
    {
        $url = 'https://restapi.amap.com/v3/weather/weatherInfo'; // 接口url地址

        // 1.对 `$format` 和 `$type` 参数进行检查，不在范围内的抛出异常
        if (!in_array(strtolower($format), ['xml', 'json'])) {
            throw new InvalidArgumentException('Invalid response format: '.$format);
        }

        if (!in_array(strtolower($type), ['base', 'all'])) {
            throw new InvalidArgumentException('Invalid type value(base/all): '.$type);
        }

        // 2.构建查询参数，对空值过滤
        $query = array_filter([
            'key' => $this->key,
            'city' => $city,
            'output' => strtolower($format),
            'extensions' => strtolower($type),
        ]);

        try {
            // 3. 调用 `getHttpClient` 方法获取 `HTTP` 请求实例，并调用 `get`方法
            // 请求 `API` 接口
            $response = $this->getHttpClient()->get($url, [
                'query' => $query,
            ])->getBody()->getContents();

            // 4. 返回值根据 `$format` 返回不同的格式
            // 当 `$format` 为 `json` 时，返回数组，否则为 `XML`。
            return 'json' === $format ? json_decode($response, true) : $response;
        } catch (\Exception $e) {
            // 5. 当调用出现异常时捕获并抛出，消息为捕获到的异常消息，
            // 并将调用异常作为 $previousException 传入。
            throw new HttpException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 获取实时天气信息.
     *
     * @param $city
     * @param string $format
     *
     * @return false|string
     *
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function getLiveWeather($city, $format = 'json')
    {
        return $this->getWeather($city, 'base', $format);
    }

    /**
     * 获取天气预报.
     *
     * @param $city
     * @param string $format
     *
     * @return false|string
     *
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function getForecastsWeather($city, $format = 'json')
    {
        return $this->getWeather($city, 'all', $format);
    }

    /**
     * 返回guzzle的HTTP实例.
     *
     * @return Client
     */
    public function getHttpClient()
    {
        return new Client($this->guzzleOptions);
    }

    /**
     * @param array $guzzleOptions
     */
    public function setGuzzleOptions(array $guzzleOptions)
    {
        $this->guzzleOptions = $guzzleOptions;
    }
}
