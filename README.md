<h1 align="center"> weather </h1>

<p align="center"> A weather SDK.</p>


## Installing

```shell
$ composer require run6/weather -vvv
```

## Usage

### 配置
   在使用本扩展之前，你需要去 [高德开放平台](https://lbs.amap.com/dev/id/newuser) 注册账号，然后创建应用，获取应用的 API Key。
### 开始
 ```php
 use Run6\Weather\Weather;
 
 $key = 'xxxxxxxxxxxxxxx'; //替换成你的API—KEY
 
 $weather = new Weather($key);

 ```
### 获取实时的天气
```php
$response = $weather->getWeather('杭州');
```
### 返回实例

```json
{
  "status": "1",
  "count": "1",
  "info": "OK",
  "infocode": "10000",
  "lives": [
    {
      "province": "浙江",
      "city": "杭州市",
      "adcode": "330100",
      "weather": "多云",
      "temperature": "33",
      "winddirection": "东",
      "windpower": "≤3",
      "humidity": "50",
      "reporttime": "2019-06-10 13:51:19"
    }
  ]
}
```

### 获取近期的天气预报

```php
$response = $weather->getWeather('杭州','all')
```

### 返回实例
```json
{
  "status": "1",
  "count": "1",
  "info": "OK",
  "infocode": "10000",
  "forecasts": [
    {
      "city": "杭州市",
      "adcode": "330100",
      "province": "浙江",
      "reporttime": "2019-06-10 13:51:19",
      "casts": [
        {
          "date": "2019-06-10",
          "week": "1",
          "dayweather": "小雨",
          "nightweather": "多云",
          "daytemp": "33",
          "nighttemp": "21",
          "daywind": "东北",
          "nightwind": "东北",
          "daypower": "≤3",
          "nightpower": "≤3"
        },
        {
          "date": "2019-06-11",
          "week": "2",
          "dayweather": "多云",
          "nightweather": "多云",
          "daytemp": "29",
          "nighttemp": "21",
          "daywind": "东北",
          "nightwind": "东北",
          "daypower": "≤3",
          "nightpower": "≤3"
        },
        {
          "date": "2019-06-12",
          "week": "3",
          "dayweather": "多云",
          "nightweather": "多云",
          "daytemp": "29",
          "nighttemp": "21",
          "daywind": "东",
          "nightwind": "东",
          "daypower": "4",
          "nightpower": "4"
        },
        {
          "date": "2019-06-13",
          "week": "4",
          "dayweather": "小雨",
          "nightweather": "晴",
          "daytemp": "29",
          "nighttemp": "18",
          "daywind": "无风向",
          "nightwind": "无风向",
          "daypower": "≤3",
          "nightpower": "≤3"
        }
      ]
    }
  ]
}
```
### 获取XML格式返回值

 第三个参数为返回值类型，可选 `json` 与 `xml` ， 默认 `json`:
 ```php
 $response = $weather('杭州','base','xml')
 ```
 
### 返回实例

```xml
<response>
  <status>1</status>
  <count>1</count>
  <info>OK</info>
  <infocode>10000</infocode>
  <lives type="list">
    <live>
      <province>浙江</province>
      <city>杭州市</city>
      <adcode>330100</adcode>
      <weather>多云</weather>
      <temperature>33</temperature>
      <winddirection>东</winddirection>
      <windpower>≤3</windpower>
      <humidity>50</humidity>
      <reporttime>2019-06-10 13:51:19</reporttime>
    </live>
  </lives>
</response>
```
###  参数说明
```php
array|string getWeather(string $city, string $type = 'base', string $format = 'json')
```
> - `$city` - 城市名，比如："杭州";
> - `$type` - 返回内容：`base`： 返回实时天气 / `all`:返回天气预报
> - `$format` - 输出的数据格式，默认为 `json`, 当设置为 `xml` 时，输出XML格式数据。

### Laravel 中使用
在 Laravel 中使用也是同样的安装方式，配置写在 `config/services.php` 中
```php
    .
    .
    .
    'weather' => [
        'key' => env('WEATHER_API_KEY'),
    ]   
```
然后在 `.env` 文件中配置 `WEATHER_API_KEY`

```php
WEATHER_API_KEY=xxxxxxxxx
```
可以使用两种方式获取 `Run6\Weather\Weather` 实例：
#### 方式参数注入

```php
    ·
    ·
    ·
    // 在控制器中通过依赖注入的方式
    public function getWeather(Weather $weather)
    {
        $response = $weather->getWeather('杭州');
    }
    .
    .
    .
```

#### 服务名访问
```php
    .
    .
    .
    pubcli function getWeather()
    {
        $response = app('weather')->getWeather('杭州');
    }
    .
    .
    .
```

## 参考

- [高德开放平台天气接口](https://lbs.amap.com/api/webservice/guide/api/weatherinfo/)

## Contributing

You can contribute in one of three ways:

1. File bug reports using the [issue tracker](https://github.com/run6/composer-test/issues).
2. Answer questions or fix bugs on the [issue tracker](https://github.com/run6/composer-test/issues).
3. Contribute new features or update the wiki.

_The code contribution process is not very formal. You just need to make sure that you follow the PSR-0, PSR-1, and PSR-2 coding guidelines. Any new code contributions must be accompanied by unit tests where applicable._

## License

MIT
