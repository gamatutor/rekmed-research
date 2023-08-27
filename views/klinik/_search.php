<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\KlinikSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="klinik-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'klinik_id') ?>

    <?= $form->field($model, 'klinik_nama') ?>

    <?= $form->field($model, 'alamat') ?>

    <?= $form->field($model, 'nomor_telp_1') ?>

    <?= $form->field($model, 'nomor_telp_2') ?>

    <?php // echo $form->field($model, 'kepala_klinik') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
