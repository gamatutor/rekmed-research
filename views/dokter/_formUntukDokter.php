<?php
use app\models\Spesialis;
use app\models\RefProvinsi;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
/* @var $this yii\web\View */
/* @var $model app\models\Dokter */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dokter-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($user, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($user, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'tanggal_lahir')->widget(
        DatePicker::className(), [
             'value' => date('Y-m-d'),
             'inline' => true,
             'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
    ]); ?>

    <?= $form->field($model, 'no_telp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_telp_2')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'spesialis')->dropDownList(
      ArrayHelper::map(Spesialis::find()->all(), 'spesialis_id', 'nama')
    ) ?>
    <?= $form->field($model, 'provinsi_id')->dropDownList(ArrayHelper::map(RefProvinsi::find()->all(), 'provinsi_id', 'provinsi_nama'), ['id'=>'provinsi-id']) ?>

    <?= $form->field($model, 'kota_id')->widget(DepDrop::classname(), [
            'options'=>['id'=>'kota-id'],
            'pluginOptions'=>[
                'depends'=>['provinsi-id'],
                'placeholder'=>'Pilih Kota/Kabupaten...',
                'url'=>Url::to(['dokter/kokab'])
            ]
        ]); ?>
    <?= $form->field($model, 'alamat')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'waktu_praktek')->textInput(['maxlength' => true]) ?>
    <?= $form->field($user, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'alumni')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'pekerjaan')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'jenis_kelamin')->dropDownList([ 'Laki Laki' => 'Laki Laki', 'Perempuan' => 'Perempuan', ]) ?>
    <?= $form->field($model, 'imageFile')->fileInput() ?>


    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
