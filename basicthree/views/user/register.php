<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Register';

$form = ActiveForm::begin([
    'id' => 'registration-form',
    'options' => ['class' => 'form-horizontal'],
]) ?>

<?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

<?= $form->field($model, 'email')->textInput() ?>

<?= $form->field($model, 'password')->passwordInput() ?>

<div class="form-group">
    <div class="col-lg-offset-1 col-lg-11">
        <?= Html::submitButton('Register', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>
