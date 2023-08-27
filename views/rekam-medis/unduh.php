<?php 
use yii\helpers\Html;
$this->title = "Rekam Medis ".$pasien->mr." ".$model->created;
?>
<table class="table table-bordered">
    <tbody>
        <tr>
            <th style="width:30%">No. RM</th>
            <td><?= Html::encode($pasien->mr) ?></td>
        </tr>
        <tr>
            <th>Tanggal Periksa</th>
            <td><?= date("d-m-Y H:i", strtotime($model->created)); ?></td>
        </tr>
        <tr>
            <th>Nama & Umur Pasien</th>
            <td><?= Html::encode($pasien->nama) ?> (<?= !(empty($pasien->tanggal_lahir)) ? $pasien->getAge($pasien->tanggal_lahir) : 0 ?> Tahun) </td>
        </tr>
    
        <tr>
            <th>Alamat Pasien</th>
            <td><?= Html::encode($pasien->alamat) ?></td>
        </tr>
    </tbody>
</table>
<table class="table table-bordered">
<tbody>
        <tr>
            <th>TD</th>
            <th>Nadi</th>
            <th>RR</th>
            <th>Suhu</th>
            <th>BB</th>
            <th>TB</th>
            <th>BMI</th>
        </tr>
        <tr>
            <td><?= $model->tekanan_darah ?></td>
            <td><?= $model->nadi ?></td>
            <td><?= $model->respirasi_rate ?></td>
            <td><?= $model->suhu ?> C</td>
            <td><?= $model->berat_badan ?> Kg</td>
            <td><?= $model->tinggi_badan ?>cm</td>
            <td><?= number_format($model->bmi, 2) ?></td>
        </tr>
</tbody>
</table>
<?php print_r($model->getAttributeLabel('anamnesis')); ?>
<table class="table table-bordered">
<tbody>

        <tr>
            <th style="width:20%">Keluhan Utama</th>
            <td><?= $model->keluhan_utama ?></td>
        </tr>
        <tr>
            <th><?= $model->getAttributeLabel('anamnesis') ?></th>
            <td><?= $model->anamnesis ?></td>
        </tr>
        <tr>
            <th><?= $model->getAttributeLabel('pemeriksaan_fisik') ?></th>
            <td><?= $model->pemeriksaan_fisik ?></td>
        </tr>
        <tr>
            <th><?= $model->getAttributeLabel('assesment') ?></th>
            <td><?= $model->assesment ?></td>
        </tr>
        <tr>
            <th><?= $model->getAttributeLabel('plan') ?></th>
            <td><?= $model->plan ?></td>
        </tr>
        <!-- <tr>
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
                    <li><?= $value['nama_diagnosis'] ?></li>
                <?php endforeach; ?>
                </ul>
            </td>
        </tr>
        <tr>
            <th>Diagnosis 2 (ICD-10)</th>
            <td>
                <ul>
                <?php foreach($rm_diagnosis_banding as $value): ?>
                    <li><?= $value['nama_diagnosis'] ?></li>
                <?php endforeach; ?>
                </ul>
            </td>
        </tr>
        <tr>
            <th>Tindakan</th>
            <td>
                <ul>
                <?php foreach($rm_tindakan as $value): ?>
                    <li><?= Html::encode($value['nama_tindakan']) ?></li>
                <?php endforeach; ?>
                </ul>
            </td>
        </tr>
        <!-- <tr>
            <th>Deskripsi Tindakan</th>
            <td><?= $model->deskripsi_tindakan ?></td>
        </tr> -->
        <tr>
            <th>Alergi Obat</th>
            <td><?= $model->alergi_obat ?></td>
        </tr>
    </tbody>
</table>
<h4>Obat</h4>
<table class="table table-bordered">
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

<h4>Obat Racik</h4>

<?php foreach($rm_obatracik as $value): ?>
<table  class="table table-bordered">
    <thead>
        <tr>
            <th>Nama Obat</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
            <?php foreach($rm_obatracik_komponen[$value['racik_id']] as $val): ?>
                <tr>
                    <td><?= Html::encode($val['nama_obat']) ?></td>
                    <td><?= Html::encode($val['jumlah']) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="2">M.F.Pulv : <?= $value['jumlah'] ?></td>
            </tr>
            <tr>
                <td colspan="2">Signa : <?= Html::encode($value['signa']) ?></td>
            </tr>
    </tbody>
</table>
<?php endforeach; ?>

    <table style="padding-top:100px" border="0" align="right" width="35%">

    <tr height="100">
        <td align="center"><strong>(<?= Html::encode(ucwords($model->user->dokter->nama)) ?>)</strong></td>
    </tr>
</table>
