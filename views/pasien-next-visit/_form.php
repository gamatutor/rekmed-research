<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\models\PasienNextVisit */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pasien-next-visit-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'agenda')->textInput(['maxlength' => true]) ?>
        </div>
        
        <div class="col-md-6">
            <?= $form->field($model, 'next_visit')->widget(
                DatePicker::className(), [
                     'value' => date('Y-m-d'),
                     // 'inline' => true,             
                     'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd'
                    ]
            ]); ?>
        </div>
        
        <div class="col-md-12">
            <?= \yii\redactor\widgets\Redactor::widget([
                'model' => $model,
                'attribute' => 'desc',
            ]) ?>
        </div>
        
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Tambahkan' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
