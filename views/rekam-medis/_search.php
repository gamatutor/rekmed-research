<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RekamMedisSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rekam-medis-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'rm_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'kunjungan_id') ?>

    <?= $form->field($model, 'mr') ?>

    <?= $form->field($model, 'tekanan_darah') ?>

    <?php // echo $form->field($model, 'nadi') ?>

    <?php // echo $form->field($model, 'respirasi_rate') ?>

    <?php // echo $form->field($model, 'suhu') ?>

    <?php // echo $form->field($model, 'berat_badan') ?>

    <?php // echo $form->field($model, 'tinggi_badan') ?>

    <?php // echo $form->field($model, 'bmi') ?>

    <?php // echo $form->field($model, 'keluhan_utama') ?>

    <?php // echo $form->field($model, 'anamnesis') ?>

    <?php // echo $form->field($model, 'pemeriksaan_fisik') ?>

    <?php // echo $form->field($model, 'hasil_penunjang') ?>

    <?php // echo $form->field($model, 'deskripsi_tindakan') ?>

    <?php // echo $form->field($model, 'saran_pemeriksaan') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'modified') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
