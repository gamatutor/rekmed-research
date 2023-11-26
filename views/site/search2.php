<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title                   = 'Hasil Pencarian';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <ul class="list-group">
        <?php foreach ($data as $key => $value): ?>
            <li class="list-group-item">
                <a href="<?= Yii::$app->urlManager->createUrl(['rekam-medis/detail', 'id' => 0]) ?>">
                    <?= $value['mr'] ?>
                    <?= $value['klinik_id'] ?>
                    <?= $value['nama'] ?>
                    <?= $value['tanggal_lahir'] ?>
                    <?= $value['jk'] ?>
                    <?= $value['alamat'] ?>
                    <?= $value['no_telp'] ?>
                    <?= $value['pekerjaan'] ?>
                    <?= $value['rm_id'] ?>
                    <?= $value['tekanan_darah'] ?>
                    <?= $value['nadi'] ?>
                    <?= $value['respirasi_rate'] ?>
                    <?= $value['suhu'] ?>
                    <?= $value['berat_badan'] ?>
                    <?= $value['tinggi_badan'] ?>
                    <?= $value['bmi'] ?>
                    <?= $value['assesment'] ?>
                    <?= $value['plan'] ?>
                    <?= $value['keluhan_utama'] ?>
                    <?= $value['anamnesis'] ?>
                    <?= $value['pemeriksaan_fisik'] ?>
                    <?= $value['hasil_penunjang'] ?>
                    <?= $value['deskripsi_tindakan'] ?>
                    <?= $value['saran_pemeriksaan'] ?>
                    <?= $value['alergi_obat'] ?>
                    <?= $value['nama_obat'] ?>
                    <?= $value['diagnosis'] ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

</div>