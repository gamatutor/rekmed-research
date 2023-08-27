<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AccessHistorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="access-history-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user') ?>

    <?= $form->field($model, 'ip_address') ?>

    <?= $form->field($model, 'host') ?>

    <?= $form->field($model, 'agent') ?>

    <?php // echo $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'time_akses') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
