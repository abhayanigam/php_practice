<?php

use yii\helpers\Html;

$this->title = 'Weather & Postal Code Result';
?>

<h1><?= Html::encode($this->title) ?></h1>

<h2>Weather Information</h2>
<p>City: <?= isset($weatherData['location']['name']) ? $weatherData['location']['name'] : 'N/A' ?>, <?= isset($weatherData['location']['country']) ? $weatherData['location']['country'] : 'N/A' ?></p>
<p>Condition: <?= isset($weatherData['current']['condition']['text']) ? $weatherData['current']['condition']['text'] : 'N/A' ?></p>
<p>Temperature: <?= isset($weatherData['current']['temp_c']) ? $weatherData['current']['temp_c'] . '°C' : 'N/A' ?></p>

<h2>Postal Code Information</h2>
<?php if (!empty($postalData['city'])) : ?>
    <p>City: <?= $postalData['city'] ?></p>
    <p>State: <?= $postalData['state'] ?></p>
    <p>Country: <?= $postalData['country'] ?></p>
<?php else : ?>
    <p>No postal data available</p>
<?php endif; ?>
