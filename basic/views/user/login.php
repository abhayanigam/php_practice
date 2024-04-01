<!-- views/user/login.php -->

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Login';

$form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'form-horizontal'],
]) ?>

<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

<?= $form->field($model, 'password')->passwordInput() ?>

<div class="form-group">
    <div class="col-lg-offset-1 col-lg-11">
        <?= Html::submitButton('Login', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
