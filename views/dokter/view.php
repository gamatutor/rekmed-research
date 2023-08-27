<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Pasien;

$pasien = new Pasien();

$this->registerCssFile('@web/metronic/pages/css/profile.min.css',['depends'=>'app\assets\MetronicAsset']);

/* @var $this yii\web\View */
/* @var $model app\models\Dokter */

$this->title = 'Profil : '.Html::encode($model->nama);
?>
<center><h3>Profil Dokter</h3></center>
<br/>
<div class="row">
    <div class="col-md-3">
        <div class="profile-userpic">
            <?= empty($model->foto) ? Html::img('@web/img/DR-avatar.png',['class'=>'img-responsive']) : Html::img('@web/'.$model->foto,['class'=>'img-responsive']) ?>
        </div>
        <div class="profile-usertitle">
            <div class="profile-usertitle-name"> <?= Html::encode($model->nama) ?> </div>
            <div class="profile-usertitle-job"> <?= !empty($model->tanggal_lahir) ? $pasien->getAge($model->tanggal_lahir).' Tahun' : '-' ?>     </div>
        </div>
        <!-- END SIDEBAR USER TITLE -->
        <!-- SIDEBAR BUTTONS -->
        <div class="profile-userbuttons">
            <?= Html::a('Update Data Dokter', ['update', 'id' => $model->user_id], ['class' => 'btn btn-circle green btn-sm']) ?>
            <?php echo Yii::$app->user->identity->role==10? Html::a('Masuk Mode Simulasi', ['switch-role', 'id' => $model->user_id], ['class' => 'btn btn-circle red btn-sm']):"" ?>
        </div>
    </div>
    <div class="col-md-9">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'nama',
                'jenis_kelamin',
                'tanggal_lahir',
                'spesialisasi.nama',
                'no_telp',
                'no_telp_2',
                'kota.kokab_nama',
                'email',
                'alumni',
                'pekerjaan',
                'alamat:ntext',
                'created',
            ],
        ]) ?>
    </div>
</div>
<hr>
<center><h3>Profil Klinik</h3></center>
<br/>
<div class="row">
    <div class="col-md-3">
        <div class="profile-usertitle">
            <div class="profile-usertitle-name"> <?= Html::encode($model_klinik->klinik_nama) ?> </div>
            <div class="profile-usertitle-job"><?= Html::encode($model_klinik->alamat) ?></div>
        </div>
        <!-- END SIDEBAR USER TITLE -->
        <!-- SIDEBAR BUTTONS -->
        <div class="profile-userbuttons">
            <?= Html::a('Update Data Klinik', ['update-klinik', 'id' => $model->user_id], ['class' => 'btn btn-circle green btn-sm']) ?>
        </div>
    </div>
    <div class="col-md-9">
        <?= DetailView  ::widget([
            'model' => $model_klinik,
            'attributes' => [
                'klinik_nama',
                'alamat:ntext',
                'nomor_telp_1',
                'nomor_telp_2',
                'kepala_klinik',
            ],
        ]) ?>
    </div>
</div>

