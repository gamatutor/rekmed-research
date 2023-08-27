<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TemplateSoapSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="template-soap-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nama_template') ?>

    <?= $form->field($model, 'subject') ?>

    <?= $form->field($model, 'object') ?>

    <?= $form->field($model, 'assesment') ?>

    <?php // echo $form->field($model, 'plan') ?>

    <?php // echo $form->field($model, 'user') ?>

    <?php // echo $form->field($model, 'created') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
