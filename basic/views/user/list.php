<?php

use yii\helpers\Html;

$this->title = 'User List';

foreach ($users as $user) {
    echo Html::encode($user->username) . "<br>";
    echo Html::encode($user->email) . "<br><br>";
}