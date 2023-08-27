<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Dokter;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Kunjungan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kunjungan-form">

    <?php $form = ActiveForm::begin(["id"=>"form-pasien"]); ?>
    
    <?= $form->field($model, 'dokter_periksa')->dropDownList(
      ArrayHelper::map(Dokter::find()->joinWith('user')->where(['klinik_id'=>Yii::$app->user->identity->klinik_id,'status'=>10])->all(), 'user_id', 'nama')
    ) ?>

    <div class="form-group">
        <label class="control-label" for="cari-pasien">Cari Pasien (No Rekam Medis/Nama/Alamat)</label>
        <input type="text" placeholder="Ketik No Rekam Medis/Nama/Alamat..." class="form-control" id="cari-pasien">
    </div>
    
    <div class="form-group" id="hasil-pasien">
        
    </div>



    <?= Html::hiddenInput('mr','',['id'=>'mr-pasien']) ?>


    <?php ActiveForm::end(); ?>

</div>


<?php
$urlCari = Url::to(['pasien/cari']);
$script = <<< JS
    $(function(){
        $('#cari-pasien').keyup(function(){
          if($(this).val().length<2) {
            $('#hasil-pasien').html("");
            return false;
          }

          $.post('{$urlCari}',{keyword:$(this).val()})
          .done(function(data){
            str_hasil = "<table class='table table-bordered'>";
            str_hasil += "<thead><tr><th>No RM</th><th>Nama</th><th>Alamat</th><th></th></tr>";
            str_hasil += "<tbody>";
            data = JSON.parse(data);
            for(var i in data){
              str_hasil += "<tr><td>"+data[i].mr+"</td><td>"+data[i].nama+"</td><td>"+data[i].alamat+"</td><td><button type='button' class='pilih-pasien btn btn-primary' value='"+data[i].mr+"'>Pilih</button>  </td></tr>"
            }
            str_hasil += "</tbody>";
            str_hasil += "</table>";
            $('#hasil-pasien').html(str_hasil);
            $('#form-pasien button:button').click(function() {
                $(this).attr('disabled', true);
            });
            $('.pilih-pasien').on('click',function(){
                  
                  $('#mr-pasien').val($(this).val());
                  $('#form-pasien').yiiActiveForm('validate');
                  $('#form-pasien').yiiActiveForm('submitForm');
            })
          });
        })

        $(window).keydown(function(event){
          if(event.keyCode == 13) {
            event.preventDefault();
            return false;
          }
        });

        
    });

JS;

$this->registerJs($script);
?>

