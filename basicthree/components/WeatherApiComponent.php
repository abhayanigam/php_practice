// components/WeatherApiComponent.php

namespace app\components;

use Yii;
use yii\base\Component;

class WeatherApiComponent extends Component
{
    public function getWeatherData($apiKey, $location)
    {
        $url = "https://api.weatherapi.com/v1/current.json?key=$apiKey&q=$location";
        $client = new \yii\httpclient\Client();
        $response = $client->createRequest()
            ->setMethod('GET')
            ->setUrl($url)
            ->send();

        if ($response->isOk) {
            return $response->content;
        } else {
            Yii::error("WeatherAPI request failed: " . $response->statusCode);
            return null;
        }
    }
}

