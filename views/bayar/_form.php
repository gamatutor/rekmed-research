<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Pasien;
use app\models\Tindakan;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
$pasien = new Pasien();
/* @var $this yii\web\View */
/* @var $model app\models\Bayar */
/* @var $form yii\widgets\ActiveForm */
$subtotal = 0;
$url_tindakan = Url::to(['bayar/get-tindakan']);
?>

<div class="bayar-form">

    <?php $form = ActiveForm::begin(['id'=>'form-bayar']); ?>
    <div class="row static-info">
        <div class="col-md-6 value"> <h4>No. Invoice</h4><h4><?= $model->no_invoice ?></h4></div>
    
        <div class="col-md-6 name">
            <?php 
                echo Html::encode($kunjungan['mr'])."<br/>";
                echo "<strong>".Html::encode($kunjungan['mr0']['nama'])."</strong><br/>";
                echo Html::encode($kunjungan['mr0']['alamat'])."<br/>";
                echo Html::encode($kunjungan['mr0']['jk'])."<br/>";
                echo $pasien->getAge($kunjungan['mr0']['tanggal_lahir'])." Tahun";
            ?>
        </div>
    </div>
    <div class="row static-info">
        <div class="col-md-6 name">Tindakan</div>
        <div class="col-md-6 value"></div>
    </div>
    <div class="row static-info">
        <div class="col-md-12 value">
            <div class="form-group">
                <?php

                echo Select2::widget([
                    'name' => 'tindakan',
                    'id' => 'select-tindakan',
                    'value' => isset($rm_tindakan) ? $rm_tindakan : [],
                    'data' => ArrayHelper::map(Tindakan::find()->where(['klinik_id'=>Yii::$app->user->identity->klinik_id])->all(), 'tindakan_id', 'nama_tindakan'),
                    'options' => ['placeholder' => 'Pilih Tindakan', 'multiple' => true],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                    'pluginEvents' => [
                        "change" => "function() { 
                            if(\$(this).val()==null) $('#daftar-tindakan').html('')
                            else
                            $.post( '$url_tindakan', { ids: \$(this).val()})
                              .done(function( data ) {
                                $('#daftar-tindakan').html(data)
                                calculateTotal()
                            });

                         }",
                    ]
                    
                ]);
                ?>
            </div>
        </div>
        

    </div>
    <div class="row static-info">
        <?php foreach($tindakan as $val): ?>
        <div class="col-md-1 value"></div>
        <div class="col-md-6 name"><?= Html::encode($val['nama_tindakan']) ?></div>
        <div class="col-md-5 value bayar_total">Rp <?= number_format($val['total_tarif'],0,'','.') ?></div>
        <?php $subtotal += $val['total_tarif'];  ?>
        <?php endforeach; ?>
    </div>
    <div class="row static-info" id="daftar-tindakan">

    </div>
    <div class="row static-info">
        <div class="col-md-6 name">Obat</div>
        <div class="col-md-6 value"></div>
    </div>
    <div class="row static-info">
        <?php foreach($obat as $val): ?>
        <div class="col-md-1 value"></div>
        <div class="col-md-5 name"><?= Html::encode($val['nama_merk']) ?></div>
        <div class="col-md-1 name" style="text-align:right"><?= $val['jumlah'] ?></div>
        <div class="col-md-5 value bayar_total">Rp <?= number_format($val['jumlah']*$val['harga_jual'],0,'','.') ?></div>
        <?php $subtotal += ($val['jumlah']*$val['harga_jual']);  ?>
        <?php endforeach; ?>
        <?php foreach($obat_racik as $val): ?>
        <div class="col-md-1 value"></div>
        <div class="col-md-5 name"><?= Html::encode($val['nama_merk']) ?></div>
        <div class="col-md-1 name" style="text-align:right"><?= $val['jumlah'] ?></div>
        <div class="col-md-5 value bayar_total">Rp <?= number_format($val['jumlah']*$val['harga_jual'],0,'','.') ?></div>
        <?php $subtotal += ($val['jumlah']*$val['harga_jual']);  ?>
        <?php endforeach; ?>
    </div>
    <hr/>
    <div class="row static-info">
        <div class="col-md-7 name">Total</div>
        <div class="col-md-5 value" id="total-bayar">
            Rp <?= number_format($subtotal,0,'','.') ?>
            <?= Html::hiddenInput('subtotal', $subtotal); ?>
        </div>
    </div>
    <div class="row static-info">
        <div class="col-md-7 name">Bayar</div>
        <div class="col-md-5 value"><?= $form->field($model, 'bayar')->textInput(['maxlength' => true])->label(false) ?></div>
    </div>

    <div class="row static-info">
        <div class="col-md-7 name">Kembali</div>
        <div id="kembali" class="col-md-5 value"></div>
    </div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Bayar' : 'Update', ['style'=>'width:100%','class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

$this->registerJsFile('@web/plugins/jquery.mask.min.js',['depends'=>'app\assets\MetronicAsset']);
$this->registerJsFile('@web/plugins/numeral.min.js',['depends'=>'app\assets\MetronicAsset']);

$script = <<< JS
    function calculateTotal()
    {
        var semua_total = 0;
        $('.bayar_total').each(function(){
            semua_total += parseInt($(this).html().replace('Rp','').replace('.','').replace(' ',''));
        })
        htm = "Rp "+numeral(semua_total).format('0,0');
        htm += '<input type="hidden" name="subtotal" value="'+semua_total+'">';
        $('#total-bayar').html(htm);
    }

    $(function(){
        
        $('#form-bayar button:submit').click(function() {
            $('#form-bayar').submit();
            $(this).attr('disabled', true);
        });
        $('#bayar-bayar').mask('000.000.000.000.000', {reverse: true});
        $('#bayar-bayar').keyup(function(){
            var total_bayar = parseInt($('#total-bayar').html().split(".").join("").replace('Rp ',''));
            var bayar = parseInt($('#bayar-bayar').val().split(".").join(""));
            var kembali = bayar - total_bayar;
            $('#kembali').html("Rp "+numeral(kembali).format('0,0'));
        })
    });



JS;
$this->registerJs($script);

?>