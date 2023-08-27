<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Kunjungan;
use app\models\Dokter;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
$model_kunjungan = new Kunjungan();
/* @var $this yii\web\View */
/* @var $model app\models\Pasien */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pasien-form">

    <?php $form = ActiveForm::begin(['options' => ['id'=>'form-pasien','enctype' => 'multipart/form-data']]); ?>

    <div class="form-group field-pasien-no_nik">
        <label class="control-label" for="pasien-MR">No.Rekam Medis</label>
        <?php $model->mr = substr($model->mr, strlen(Yii::$app->user->identity->klinik_id)); ?>
        <?= $form->field($model, 'mr', ['template'=>"<span class='input-group-addon' id='basic-addon1'>".Yii::$app->user->identity->klinik_id."</span>{input}",'options' => [
            // 'tag' => null,
            'class' => 'input-group',
        ],])->textInput(['maxlength' => 6, 'minlength' => 6, 'readonly'=>!$model->isNewRecord]) ?>
        <?= $form->field($model, 'mr', ['template'=>"{hint}\n{error}"])->textInput(['maxlength' => true]) ?>
    </div>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'no_nik')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tanggal_lahir')->widget(
        DatePicker::className(), [
             'value' => date('Y-m-d'),
             'inline' => true,             
             'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
    ]); ?>


    <?= $form->field($model, 'jk')->dropDownList([ 'Laki-Laki' => 'Laki-Laki', 'Perempuan' => 'Perempuan', ]) ?>

    <?= $form->field($model, 'alamat')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'no_telp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pekerjaan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'penanggung_jawab')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model_kunjungan, 'dokter_periksa')->dropDownList(
      ArrayHelper::map(Dokter::find()->joinWith('user')->where(['klinik_id'=>Yii::$app->user->identity->klinik_id,'status'=>10])->all(), 'user_id', 'nama')
    ) ?>
    <?= $form->field($model, 'imageFile')->fileInput() ?>
    
    <div class="form-group">
        <?= Html::submitInput('Simpan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','name'=>'Simpan']) ?>

        <?= Html::submitInput('Simpan dan Tambahkan ke Antrian', ['class'=>'btn btn-danger','name'=>'Antrian']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
    $(function(){
        $('#form-pasien input:submit').click(function() {
            $('#form-pasien').submit();
            $(this).attr('disabled', true);
        });
    });

JS;

$this->registerJs($script);

?>