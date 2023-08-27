<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Update Klinik';
/* @var $this yii\web\View */
/* @var $model app\models\Klinik */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="klinik-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'klinik_nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alamat')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'nomor_telp_1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nomor_telp_2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kepala_klinik')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Update Klinik', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

