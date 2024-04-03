<?php

namespace app\models\forms;

use yii\base\Model;

class WeatherForm extends Model
{
    public $location;
    public $postalCode; // New attribute for postal code

    public function rules()
    {
        return [
            [['location'], 'required'],
            [['postalCode'], 'safe'], // Postal code is optional
        ];
    }
}
