<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Klinik;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

<?= $form->field($model, 'username') ?>
<?= $form->field($model, 'email') ?>

<?= empty($model->username) ? $form->field($model, 'password')->passwordInput() :  "" ?>

<?= $form->field($model, 'klinik_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Klinik::find()->all(), 'klinik_id', 'klinik_nama'),
        'options' => ['placeholder' => 'Pilih Klinik...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
?>

<?= $form->field($model, 'role')->widget(Select2::classname(), [
        'data' => ["10"=>"Admin","20"=>"Admin Dokter","25"=>"Dokter"],
        'options' => ['placeholder' => 'Pilih Role...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
?>

<div class="form-group">
    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
</div>

<?php ActiveForm::end(); ?>
            

    

