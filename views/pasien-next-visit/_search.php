<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\PasienNextVisitSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pasien-next-visit-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'pasien_schedule_id') ?>

    <?= $form->field($model, 'mr') ?>

    <?= $form->field($model, 'agenda') ?>

    <?= $form->field($model, 'desc') ?>

    <?= $form->field($model, 'next_visit') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
