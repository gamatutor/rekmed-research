<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use app\models\Spesialis;
/* @var $this yii\web\View */
/* @var $model app\models\RekamMedis */

$this->title = 'Data Rekam Medis';
$this->params['breadcrumbs'][] = ['label' => 'Rekam Medis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/metronic/pages/css/profile.min.css',['depends'=>'app\assets\MetronicAsset']);
?>

<?php
    Modal::begin([
            'header' => '<h4>Pasien</h4>',
            'id' => 'modal',
        ]);

    echo "<div id='modalContent'></div>";

    Modal::end();

?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            
            <div class="portlet-body">
                <div>
                    <ul class="pagination">
                        <?php foreach($histori_rm as $val): ?>
                            <?php 
                            $time = strtotime($val['created']);
                            $myFormatForView = date("d F Y", $time);
                            if($val['rm_id']==$model->rm_id)
                            ?>
                            <li <?= $val['rm_id']==$model->rm_id ? 'class="active"' : "" ?>>
                                <a href="<?= Url::to(['rekam-medis/view','id'=>utf8_encode(Yii::$app->security->encryptByKey( $val['rm_id'], Yii::$app->params['kunciInggris'] ))]) ?>"> <?= $myFormatForView ?> </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PROFILE SIDEBAR -->
        <div class="profile-sidebar">
            <!-- PORTLET MAIN -->
            <div class="portlet light profile-sidebar-portlet bordered">
                <?php if(!empty($pasien->foto)): ?>
                <div class="profile-userpic">
                    <?= Html::img('@web/'.$pasien->foto,['class'=>'img-responsive']) ?>
                </div>
                <?php endif; ?>
                <!-- SIDEBAR USER TITLE -->
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name"> <?= Html::encode($pasien->nama) ?> </div>
                    <div class="profile-usertitle-job"> <?= !(empty($pasien->tanggal_lahir)) ? $pasien->getAge($pasien->tanggal_lahir) : 0 ?> Tahun </div>
                    <div class="profile-usertitle-job"> <?= Html::encode($pasien->alamat) ?> </div>
                </div>
                <!-- END SIDEBAR USER TITLE -->
                <!-- SIDEBAR BUTTONS -->
                <div class="profile-userbuttons">
                    <?= Html::a('Edit', Url::to(['rekam-medis/update','id'=>utf8_encode(Yii::$app->security->encryptByKey( $model->rm_id, Yii::$app->params['kunciInggris'] ))]),['class'=>'btn btn-circle green btn-sm']) ?>
                     <?= Html::a('Cetak Resep', Url::to(['rekam-medis/cetak-resep','id'=>utf8_encode(Yii::$app->security->encryptByKey( $model->rm_id, Yii::$app->params['kunciInggris'] ))]),['class'=>'btn btn-circle green btn-sm','target' => '_blank']) ?>
                    <br>
                    <br>
                    <?= Html::button('Detail Pasien', ['value'=>Url::to(['pasien/view','id'=>$pasien->mr]),'class' => 'btn btn-circle green btn-sm modalWindow']) ?>
                    
                    <?= Html::button('Janjian Periksa', [
                            'value'=>Url::to(['pasien-next-visit/create','id'=>$model->mr0->mr]),
                            'class'=>'btn btn-circle green btn-sm modalWindow',
                            'title' => Yii::t('yii', 'Tambah Reminder'),
                            'data-pjax' => '0',
                        ]); ?>
                </div>
                <!-- END SIDEBAR BUTTONS -->
                <!-- SIDEBAR MENU -->
                <div class="profile-usermenu">
                    
                </div>
                <!-- END MENU -->
            </div>

            <div class="portlet light profile-sidebar-portlet bordered">
                <div class="profile-usertitle">
                    <div class="profile-usertitle-name">UNDUH BERKAS</div>
                </div>
                <div class="profile-userbuttons">
                    <div class="btn-group btn-group-justified">
                        <?= Html::a(' Rekam Medis ', Url::to(['rekam-medis/unduh-rm','id'=>utf8_encode(Yii::$app->security->encryptByKey( $model->rm_id, Yii::$app->params['kunciInggris'] ))]),['class' => 'btn btn-success']) ?>
                    </div>
                    <div class="btn-group btn-group-justified">
                        <?=Html::a(' Resume Medis ', Url::to(['pasien/resume-medis','id'=>utf8_encode(Yii::$app->security->encryptByKey( $model->mr0->mr, Yii::$app->params['kunciInggris'] )),'rmid'=>utf8_encode(Yii::$app->security->encryptByKey( $model->rm_id, Yii::$app->params['kunciInggris'] ))]),['class' => 'btn btn-success']) ?>
                    </div>
                    <div class="btn-group btn-group-justified">
                        <?= Html::a(' Surat Sehat ', Url::to(['rekam-medis/surat-sehat','id'=>utf8_encode(Yii::$app->security->encryptByKey( $model->rm_id, Yii::$app->params['kunciInggris'] ))]),['class' => 'btn btn-success']) ?>
                    </div>
                    <div class="btn-group btn-group-justified">
                        <?= Html::a(' Surat Sakit ', Url::to(['rekam-medis/surat-sakit','id'=>utf8_encode(Yii::$app->security->encryptByKey( $model->rm_id, Yii::$app->params['kunciInggris'] )),'rmid'=>utf8_encode(Yii::$app->security->encryptByKey( $model->rm_id, Yii::$app->params['kunciInggris'] ))]),['class' => 'btn btn-success']) ?>
                    </div>
                    <div class="btn-group btn-group-justified">
                        <?= Html::a(' Surat Rujukan ', Url::to(['rekam-medis/surat-rujukan','id'=>utf8_encode(Yii::$app->security->encryptByKey( $model->rm_id, Yii::$app->params['kunciInggris'] ))]),['class' => 'btn btn-success']) ?>
                    </div>
                </div>
                <?php if(Yii::$app->user->identity->spesialis==28): ?>
                    <hr>
                    <div class="profile-usertitle">
                        <div class="profile-usertitle-name">UNDUH BERKAS SPESIALIS <?= Spesialis::findOne(28)->nama ?></div>
                    </div>
                    <div class="profile-userbuttons">
                        <div class="btn-group btn-group-justified">
                            <?= Html::a(' Surat Layak melakukan perjalanan ', Url::to(['rekam-medis/surat-layak-terbang','id'=>utf8_encode(Yii::$app->security->encryptByKey( $model->rm_id, Yii::$app->params['kunciInggris'] ))]),['class' => 'btn btn-primary']) ?>
                        </div>
                        <div class="btn-group btn-group-justified">
                            <?=Html::a(' Resume Pernyataan Medis ', Url::to(['rekam-medis/surat-pernyataan-medis','id'=>utf8_encode(Yii::$app->security->encryptByKey( $model->rm_id, Yii::$app->params['kunciInggris'] )),'rmid'=>utf8_encode(Yii::$app->security->encryptByKey( $model->rm_id, Yii::$app->params['kunciInggris'] ))]),['class' => 'btn btn-primary']) ?>
                        </div>
                        <div class="btn-group btn-group-justified">
                            <?= Html::a(' Surat Keterangan Diagnosis ', Url::to(['rekam-medis/surat-keterangan-diagnosis','id'=>utf8_encode(Yii::$app->security->encryptByKey( $model->rm_id, Yii::$app->params['kunciInggris'] ))]),['class' => 'btn btn-primary']) ?>
                        </div>
                        <div class="btn-group btn-group-justified">
                            <?= Html::a(' Surat Pengantar Rujukan ', Url::to(['rekam-medis/surat-pengantar-rujukan','id'=>utf8_encode(Yii::$app->security->encryptByKey( $model->rm_id, Yii::$app->params['kunciInggris'] )),'rmid'=>utf8_encode(Yii::$app->security->encryptByKey( $model->rm_id, Yii::$app->params['kunciInggris'] ))]),['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                    <?php endIf; ?>
                <br>
            </div>
            <!-- END PORTLET MAIN -->
            <!-- PORTLET MAIN -->
            <div class="portlet light bordered">
                <!-- STAT -->
                <div class="row list-separated profile-stat">
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="uppercase profile-stat-title"> <?= $model->tekanan_darah ?> </div>
                        <div class="uppercase profile-stat-text"> TD (120/80) </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="uppercase profile-stat-title"> <?= $model->nadi ?> </div>
                        <div class="uppercase profile-stat-text"> Nadi (x/min) </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="uppercase profile-stat-title"> <?= $model->respirasi_rate ?> </div>
                        <div class="uppercase profile-stat-text"> Resp Rate (x/min) </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="uppercase profile-stat-title"> <?= $model->suhu ?> </div>
                        <div class="uppercase profile-stat-text"> Suhu (C) </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="uppercase profile-stat-title"> <?= $model->berat_badan ?> </div>
                        <div class="uppercase profile-stat-text"> BB (kg) </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="uppercase profile-stat-title"> <?= $model->tinggi_badan ?> </div>
                        <div class="uppercase profile-stat-text"> TB (cm) </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-6"></div>
                    <div class="col-md-4 col-sm-4 col-xs-6">
                        <div class="uppercase profile-stat-title"> <?= number_format($model->bmi,2,',','') ?> </div>
                        <div class="uppercase profile-stat-text"> BMI </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-6"></div>
                    
                </div>
                <!-- END STAT -->
                <div>
                    <h4 class="profile-desc-title">Keluhan Utama</h4>
                    <span class="profile-desc-text"> <?= $model->keluhan_utama ?> </span>
                    <div class="margin-top-20 profile-desc-link">
                    </div>
                    
                </div>
                <div>
                    <h4 class="profile-desc-title">Tanggal Periksa</h4>
                    <span class="profile-desc-text"> <?= $model->created ?> </span>
                    <div class="margin-top-20 profile-desc-link">
                    </div>
                    
                </div>
            </div>

            <!-- END PORTLET MAIN -->
        </div>
        <div class="profile-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        
                        <div class="portlet-body">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th style="width:20%">(S) Subyektif</th>
                                        <td><?= $model->anamnesis ?></td>
                                    </tr>
                                    <tr>
                                        <th>(O) Obyektif</th>
                                        <td><?= $model->pemeriksaan_fisik ?></td>
                                    </tr>
                                    <tr>
                                        <th>(A) Assesment</th>
                                        <td><?= $model->assesment ?></td>
                                    </tr>
                                    <tr>
                                        <th>(P) Plan</th>
                                        <td><?= $model->plan ?></td>
                                    </tr>
                                   <!--  <tr>
                                        <th>Hasil Penunjang</th>
                                        <td><?= $model->hasil_penunjang ?></td>
                                    </tr>
                                    <tr>
                                        <th>Saran Pemeriksaan</th>
                                        <td><?= $model->saran_pemeriksaan ?></td>
                                    </tr> -->
                                    <tr>
                                        <th>Diagnosis 1 (ICD-10)</th>
                                        <td>
                                            <ul>
                                            <?php foreach($rm_diagnosis as $value): ?>
                                                <li><?= !empty($value['kode']) ? $value['kode']." - ".$value['nama_diagnosis'] : $value['nama_diagnosis'] ?></li>
                                            <?php endforeach; ?>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Diagnosis 2 (ICD-10)</th>
                                        <td>
                                            <ul>
                                            <?php foreach($rm_diagnosis_banding as $value): ?>
                                                <li><?= !empty($value['kode']) ? $value['kode']." - ".$value['nama_diagnosis'] : $value['nama_diagnosis'] ?></li>
                                            <?php endforeach; ?>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tindakan</th>
                                        <td>
                                            <ul>
                                            <?php foreach($rm_tindakan as $value): ?>
                                                <li><?= $value['nama_tindakan'] ?></li>
                                            <?php endforeach; ?>
                                            </ul>
                                        </td>
                                    </tr>
<!--                                     <tr>
                                        <th>Deskripsi Tindakan</th>
                                        <td><?= $model->deskripsi_tindakan ?></td>
                                    </tr> -->
                                    <tr>
                                        <th>Alergi Obat</th>
                                        <td><?= $model->alergi_obat ?></td>
                                    </tr>
                                    <tr>
                                        <th>Obat</th>
                                        <td>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Obat</th>
                                                        <th>Jumlah</th>
                                                        <th>Signa</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tbody>
                                                        <?php foreach($rm_obat as $value): ?>
                                                            <tr>
                                                                <td><?= Html::encode($value['nama_obat']) ?></td>
                                                                <td><?= $value['jumlah'] ?></td>
                                                                <td><?= Html::encode($value['signa']) ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                <?php if (Yii::$app->user->identity->spesialis==3){ ?>
                                    <tr>
                                        <th>Obat Racik Anak</th>
                                        <td>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Obat</th>
                                                        <th>Dosis</th>
                                                        <th>Jumlah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tbody>
                                                        <?php foreach($model->rmObatAnaks as $value): ?>
                                                            <tr>
                                                                <td><?= Html::encode($value->nama_obat) ?></td>
                                                                <td><?= Html::encode($value->dosis) ?></td>
                                                                <td><?= Html::encode($value->jumlah) ?> <?= Html::encode($value->kemasan) ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                <?php } ?>
                                    <tr>
                                        <th>Obat Racik</th>
                                        <td>
                                            <?php foreach($rm_obatracik as $value): ?>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Nama Obat</th>
                                                        <th>Jumlah</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tbody>
                                                        <?php foreach($rm_obatracik_komponen[$value['racik_id']] as $val): ?>
                                                            <tr>
                                                                <td><?= Html::encode($val['nama_obat']) ?></td>
                                                                <td><?= $val['jumlah'] ?></td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                        <tr>
                                                            <td colspan="2">M.F.Pulv : <?= $value['jumlah'] ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2">Signa : <?= Html::encode($value['signa']) ?></td>
                                                        </tr>
                                                    </tbody>
                                                </tbody>
                                            </table>
                                            <?php endforeach; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END PORTLET -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h3>Upload File Penunjang</h3>
                    <?php 
                    $id = utf8_encode(Yii::$app->security->encryptByKey( $model->rm_id, Yii::$app->params['kunciInggris'] ));
                    echo \kato\DropZone::widget([
                           'options' => [
                               'url' => Url::to(['rekam-medis/upload','id'=>$id]),
                               'maxFilesize' => '2',
                           ],
                           'clientEvents' => [
                               'complete' => "function(file){console.log(file)}",
                               'removedfile' => "function(file){alert(file.name + ' is removed')}"
                           ],
                       ]);
                    ?>
                    <h4>File Penunjang Saat Ini</h4>
                    <?php foreach($data_penunjang as $key => $val): ?>
                            
                            <?php 
                            try {
                                getimagesize(Url::to('@web/'.$val['path'],true)) > 0 ? Html::a(Html::img('@web/'.$val['path'],['style'=>'height:170px','class'=>'img-responsive']),Url::to('@web/'.$val['path'],true)) : Html::a(substr(str_replace('rm_penunjang/', '', $val['path']),5),Url::to('@web/'.$val['path'],true),['class' => 'btn btn-lg green']);

                                echo Html::a('<i class="fa fa-trash-o"></i>', Url::to(['rekam-medis/delete-penunjang','id'=>utf8_encode(Yii::$app->security->encryptByKey( $val['id'], Yii::$app->params['kunciInggris'] ))]), [
                                    'title' => Yii::t('yii', 'Hapus'),
                                    'class'=> 'btn dark btn-sm btn-outline sbold uppercase',
                                    'data-confirm' => Yii::t('yii', 'Apakah Anda Yakin akan menghapus File ini?'),
                                    'data-method' => 'post',
                                ]);  
                            } catch(\Exception $e) {

                            }
                            

                            ?>
                        
                        
                    <?php endforeach; ?>
                </div>
            </div>
            
        </div>
        
    </div>
</div>

<?php
//$this->registerJsFile('@web/metronic/pages/scripts/profile.min.js',['depends'=>'app\assets\MetronicAsset']);
$script = <<< JS
    $(function(){
        $('.modalWindow').click(function(){
            $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'))
        })
    });

JS;

$this->registerJs($script);
?>

