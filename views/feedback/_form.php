<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Feedback */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="feedback-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kategori')->dropDownList([ 'Error Aplikasi' => 'Error Aplikasi', 'Request Fitur' => 'Request Fitur', 'Lainnya' => 'Lainnya', ], ['prompt' => '']) ?>

    <?= \yii\redactor\widgets\Redactor::widget([
        'model' => $model,
        'attribute' => 'isi'
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Kirim' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
