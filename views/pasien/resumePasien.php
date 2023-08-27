<?php 
use yii\helpers\Html;
$this->title = "Resume Medis ".$pasien->mr." ".date("d-m-Y H:i:s");
?>
<table class="table table-bordered">
    <tbody>
        <tr>
            <th style="width:30%">No. RM</th>
            <td><?= Html::encode($pasien->mr) ?></td>
        </tr>
        <tr>
            <th>Nama & Umur Pasien</th>
            <td><?= Html::encode($pasien->nama) ?> (<?= !(empty($pasien->tanggal_lahir)) ? $pasien->getAge($pasien->tanggal_lahir) : 0 ?> Tahun) </td>
        </tr>
        <tr>
            <th>Jenis Kelamin Pasien</th>
            <td><?= Html::encode($pasien->jk) ?></td>
        </tr>
    
        <tr>
            <th>Alamat Pasien</th>
            <td><?= Html::encode($pasien->alamat) ?></td>
        </tr>

        <?= ($pasien->nextVisit!=false)?"<tr>
            <th>Kunjungan Selanjutnya</th>
            <td>".date("d-m-Y", strtotime($pasien->nextVisit->next_visit))."(".Html::encode($pasien->nextVisit->agenda).")</td>
        </tr>":""; ?>

    </tbody>
</table>


<table class="table table-bordered">
    <tbody>
    <?php $no = 0; foreach ($rm as $key => $value): $value->decryptDulu(); ?>
        <tr>
            <td>Diagnosis</td>
            <td><?= $value->assesment ?></td>
        </tr>
        <tr>
            <td>Terapi</td>
            <td><?= $value->plan ?></td>
        </tr>
        <tr>
            <td>Riwayat</td>
            <td><?= $value->anamnesis.' '.$value->pemeriksaan_fisik ?></td>
        </tr>

        <?php 
            $hpl = date("d-m-Y",strtotime(date("Y-m-d", strtotime($value->spog_hpth)) ."+280 days")); 
            $mensH = (strtotime(date('Y-m-d')) - strtotime(date('Y-m-d', strtotime($hpl))))/86400;
            $usiaHamil = (int)(($mensH-1) / 7);
        ?>
        <?php if($dokter->spesialis==28): ?> 
        <tr>
            <td>HPHT</td>
            <td><?= date("d-m-Y",strtotime($value->spog_hpth)) ?></td>
        </tr>
        <tr>
            <td>HPL</td>
            <td><?= $hpl ?></td>
        </tr>
        <tr>
            <td>Mens Hari ke-</td>
            <td><?= $mensH ?></td>
        </tr>
        <tr>
            <td>Usia Kehamilan</td>
            <td><?= $usiaHamil ?> Minggu</td>
        </tr>
        <?php endIf; ?>
    <?php endForeach; ?>
    </tbody>
</table>

<table style="padding-top:100px" border="0" align="right" width="35%">

    <tr height="100">
        <td align="center"><strong>(<?= Html::encode(ucwords($dokter->nama)) ?>)</strong></td>
    </tr>
</table>