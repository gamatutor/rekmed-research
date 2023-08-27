<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TemplateSoap */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="template-soap-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama_template')->textInput(['maxlength' => true]) ?>

    <label>S (Subyekif)</label>
    <?= \yii\redactor\widgets\Redactor::widget([
                                'model' => $model,
                                'attribute' => 'subject',
                            ]) ?>
    
    <label>O (Obyektif)</label>
    <?= \yii\redactor\widgets\Redactor::widget([
                                'model' => $model,
                                'attribute' => 'object',
                            ]) ?>
    <label>A (Assesment)</label>
    <?= \yii\redactor\widgets\Redactor::widget([
                                'model' => $model,
                                'attribute' => 'assesment',
                            ]) ?>
    <label>P (Plan)</label>
    <?= \yii\redactor\widgets\Redactor::widget([
                                'model' => $model,
                                'attribute' => 'plan',
                            ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
