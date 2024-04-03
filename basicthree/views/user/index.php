<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Weather & Postal Code App';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'location')->textInput(['autofocus' => true])->label('Location (City, Zip Code, etc.)') ?>
<?= $form->field($model, 'postalCode')->textInput()->label('Postal Code (Optional)') ?>

<div class="form-group">
    <?= Html::submitButton('Get Weather & Postal Code', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
